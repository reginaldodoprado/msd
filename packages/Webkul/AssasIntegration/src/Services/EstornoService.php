<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class EstornoService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

  
    /**
     * Listar estornos
     */
    public function listarEstornosDaCobranca(string $id)
    {
        return $this->apiClient->get("payments/{$id}/refunds");
    }

    /**
     * Estornar boleto
     */
    public function estornarBoleto(string $id)
    {
        return $this->apiClient->post("payments/{$id}/bankSlip/refund");
    }

    /**
     * Estornar parcelamento
     */
    public function estornarParcelamento(string $id)
    {
        return $this->apiClient->post("installments/{$id}/refund");
    }
    

    /**
     * Estornar cobrança resumida
     */
    public function estornarCobrancaResumido(string $id)
    {
        return $this->apiClient->post("lean/payments/{$id}/refund");
    }

    /**
     * Estornar cobrança
     */
    public function estornarCobranca(string $id)
    {
        return $this->apiClient->post("payments/{$id}/refund");
    }

 
}
