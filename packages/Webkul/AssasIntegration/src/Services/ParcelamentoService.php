<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class ParcelamentoService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar parcelamento
     */
    public function criarParcelamento(array $dados)
    {
        return $this->apiClient->post("installments", $dados);
    }

    /**
     * Listar parcelamentos
     */
    public function listarParcelamentos(array $filtros = [])
    {
        return $this->apiClient->get("installments", $filtros);
    }

    /**
     * Criar parcelamento com cartão de crédito
     */
    public function criarParcelamentoComCartaoDeCredito(array $dados)
    {
        return $this->apiClient->post("installments", $dados);
    }

    /**
     * Recuperar parcelamento
     */
    public function recuperarParcelamento(string $id)
    {
        return $this->apiClient->get("installments/{$id}");
    }

    /**
     * Remover parcelamento
     */
    public function removerParcelamento(string $id)
    {
        return $this->apiClient->delete("installments/{$id}");
    }

    /**
     * Listar cobrancas do parcelamento
     */
    public function listarCobrancasDoParcelamento(string $id)
    {
        return $this->apiClient->get("installments/{$id}/payments");
    }
    
    /**
     * Gerar carne de parcelamento
     */
    public function gerarCarneDeParcelamento(string $id)
    {
        return $this->apiClient->get("installments/{$id}/paymentBook");
    }

    /**
     * Atualizar split do parcelamento
     */
    public function atualizarSplitDoParcelamento(string $id, array $dados)
    {
        return $this->apiClient->put("installments/{$id}/splits", $dados);
    }
    
}
