<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class ExtratoService
{
    protected $apiClient;   

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Recuperar extrato
     */ 
    public function recuperarExtrato()
    {
        return $this->apiClient->get("financialTransactions");
    }

 
}