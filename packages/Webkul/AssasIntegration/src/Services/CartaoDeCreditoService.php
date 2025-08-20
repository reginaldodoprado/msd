<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class CartaoDeCreditoService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }


    /**
     * Tokenizar cartão de crédito
     */
    public function tokenizarCartaoDeCredito(array $dados)
    {
        return $this->apiClient->post("creditCard/tokenizeCreditCard", $dados);
    }
  
}