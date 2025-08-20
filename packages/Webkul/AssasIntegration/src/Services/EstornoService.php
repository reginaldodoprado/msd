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
    public function listarEstornosDaCobranca (string $id)
    {
        return $this->apiClient->get("payments/{$id}/refunds");
    }

    /**
     * Estonar boleto
     */
    public function estornarBoleto(string $id)
    {
        return $this->apiClient->post("payments/{$id}/bankSlip/refund");
    }

    /**
     * Estonar parcela
     */
    public function estornarParcelamento(string $id)
    {
            return $this->apiClient->post("installments/{$id}/refund");
    }
    

    /**
     * Estonar cobranca resumido
     */
    public function estornarCobrancaResumido(string $id)
    {
        return $this->apiClient->post("lean/payments/{$id}/refund");
    }

    /**
     * Estonar cobranca
     */
    public function estornarCobranca(string $id)
    {
        return $this->apiClient->post("payments/{$id}/refund");
    }

 
}
