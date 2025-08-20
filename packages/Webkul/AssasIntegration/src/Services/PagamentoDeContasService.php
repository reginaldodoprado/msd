<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class PagamentoDeContasService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar pagamento de conta
     */
    public function criarPagamentoDeConta(array $dados)
    {
        return $this->apiClient->post("bill", $dados);
    }

    /**
     * Listar pagamento de conta
     */
    public function listarPagamentoDeConta(array $filtros = [])
    {
        return $this->apiClient->get("bill", $filtros);
    }

    /**
     * Simular pagamento de conta
     */
    public function simularPagamentoDeConta(array $dados)
    {
        return $this->apiClient->post("bill/simulate", $dados);
    }

    /**
     * Recuperar pagamento de conta
     */
    public function recuperarPagamentoDeConta(string $id)
    {
        return $this->apiClient->get("bill/{$id}");
    }

    /**
     * Cancelar pagamento de conta
     */
    public function cancelarPagamentoDeConta(string $id)
    {
        return $this->apiClient->post("bill/{$id}/cancel");
    }
    
    
}