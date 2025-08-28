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
                'Content-Type' => 'application/json',
                'User-Agent' => 'Laravel App',
                'access_token' => $token,
            ];

            $url = "{$this->baseUrl}/{$endpoint}";
            
        
            
            $response = Http::withHeaders($headers)
                ->{$method}($url, $options[$method === 'GET' ? 'query' : 'json'] ?? []);

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
}