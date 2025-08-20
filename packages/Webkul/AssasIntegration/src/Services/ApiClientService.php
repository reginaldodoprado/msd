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
                return $response->json();
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

 

 
}