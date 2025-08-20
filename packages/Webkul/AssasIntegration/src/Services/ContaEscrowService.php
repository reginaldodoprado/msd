<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class ContaEscrowService
{
    protected $apiClient;   

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

   /**
    * Encerrar garantia da cobranca
    */
    public function encerrarGarantiaDaCobranca(string $id)
    {
        return $this->apiClient->post("escrow/{$id}/finish");
    }
    
    
}