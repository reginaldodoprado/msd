<?php

namespace Ds\AssasIntegration\Services;

use Illuminate\Support\Facades\Http;

use Exception;

class ApiClientService
{
    protected string $baseUrl;
    protected int $maxRetries = 10;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('assas-integration.asaas.base_url'), '/');
    }

    public function get(string $endpoint, array $params = []): array
    {
        return $this->request('GET', $endpoint, ['query' => $params]);
    }

    public function post(string $endpoint, array $payload = []): array
    {
        // Verifica se há arquivos no payload para usar multipart
        $hasFiles = $this->hasFiles($payload);
        
        if ($hasFiles) {
            return $this->request('POST', $endpoint, ['multipart' => $this->prepareMultipartData($payload)]);
        }
        
        return $this->request('POST', $endpoint, ['json' => $payload]);
    }

    public function put(string $endpoint, array $payload = []): array
    {
        return $this->request('PUT', $endpoint, ['json' => $payload]);
    }

    public function delete(string $endpoint): array
    {
        return $this->request('DELETE', $endpoint, []);
    }

    private function request(string $method, string $endpoint, array $options): array
    {
        $attempts = 0;

        do {
            $token = $this->getToken();

            // Headers corretos para Asaas
            $headers = [
                'User-Agent' => 'Laravel App',
                'access_token' => $token,
            ];

            // Adiciona Content-Type apenas se não for multipart
            if (!isset($options['multipart'])) {
                $headers['Content-Type'] = 'application/json';
            }

            $url = "{$this->baseUrl}/{$endpoint}";
            
        
            
            if (isset($options['multipart'])) {
                // Para multipart, usa attach para cada arquivo
                $http = Http::withHeaders($headers);
                
                foreach ($options['multipart'] as $field) {
                    if (isset($field['contents']) && is_resource($field['contents'])) {
                        $http = $http->attach(
                            $field['name'],
                            $field['contents'],
                            $field['filename'] ?? null,
                            $field['headers'] ?? []
                        );
                    } else {
                        $http = $http->attach(
                            $field['name'],
                            $field['contents']
                        );
                    }
                }
                
                $response = $http->{$method}($url);
            } else {
                $response = Http::withHeaders($headers)
                    ->{$method}($url, $this->getRequestData($options, $method));
            }

            if ($response->status() !== 401) {
                // Verifica se a resposta é um arquivo (não JSON)
                $contentType = $response->header('Content-Type');
                $isFile = $contentType && (
                    str_contains($contentType, 'application/pdf') ||
                    str_contains($contentType, 'application/octet-stream') ||
                    str_contains($contentType, 'text/csv') ||
                    str_contains($contentType, 'application/vnd.ms-excel') ||
                    str_contains($contentType, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                );
                
                if ($isFile) {
                    // Se for arquivo, retorna informações sobre o arquivo
                    return [
                        'type' => 'file',
                        'content_type' => $contentType,
                        'size' => $response->header('Content-Length'),
                        'filename' => $this->extractFilename($response),
                        'content' => $response->body() // Conteúdo binário do arquivo
                    ];
                }
                
                // Se não for arquivo, tenta fazer JSON
                $jsonResponse = $response->json();
                // Se a resposta for null ou vazia, retorna array vazio
                return $jsonResponse ?? [];
            }

            // Para Asaas, se der 401, não tenta renovar token
            $attempts++;

        } while ($attempts < $this->maxRetries);

        throw new Exception("Erro 401 persistente após {$this->maxRetries} tentativas.");
    }

    private function getToken(): string
    {
        // Para Asaas, retorna a chave da API diretamente
        return config('assas-integration.asaas.api_key') ?? env('ASAAS_API_KEY');
    }

    /**
     * Extrai o nome do arquivo dos headers da resposta
     */
    private function extractFilename($response): ?string
    {
        // Tenta extrair do header Content-Disposition
        $contentDisposition = $response->header('Content-Disposition');
        if ($contentDisposition && preg_match('/filename="([^"]+)"/', $contentDisposition, $matches)) {
            return $matches[1];
        }
        
        // Tenta extrair do header Content-Type
        $contentType = $response->header('Content-Type');
        if ($contentType) {
            if (str_contains($contentType, 'application/pdf')) {
                return 'documento.pdf';
            } elseif (str_contains($contentType, 'text/csv')) {
                return 'dados.csv';
            } elseif (str_contains($contentType, 'application/vnd.ms-excel')) {
                return 'planilha.xls';
            } elseif (str_contains($contentType, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) {
                return 'planilha.xlsx';
            }
        }
        
        return 'arquivo';
    }

    private function hasFiles(array $payload): bool
    {
        foreach ($payload as $value) {
            if ($value instanceof \CURLFile) {
                return true;
            }
        }
        return false;
    }

    private function prepareMultipartData(array $payload): array
    {
        $multipart = [];
        
        foreach ($payload as $key => $value) {
            if ($value instanceof \CURLFile) {
                $multipart[] = [
                    'name' => $key,
                    'contents' => fopen($value->getFilename(), 'r'),
                    'filename' => $value->getPostFilename(),
                    'headers' => [
                        'Content-Type' => $value->getMimeType()
                    ]
                ];
            } else {
                $multipart[] = [
                    'name' => $key,
                    'contents' => (string) $value
                ];
            }
        }
        
        return $multipart;
    }

    private function getRequestData(array $options, string $method): array
    {
        if ($method === 'GET') {
            return $options['query'] ?? [];
        }
        
        if (isset($options['multipart'])) {
            return $options['multipart'];
        }
        
        return $options['json'] ?? [];
    }
}