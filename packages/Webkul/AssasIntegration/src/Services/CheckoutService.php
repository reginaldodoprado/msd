<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class CheckoutService
{
    protected $apiClient;


    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar um checkout
     */
    public function criarCheckout(array $dados)
    {
        return $this->apiClient->post("checkouts", $dados);
    }

    /**
     * Cancelar um checkout
     */
    public function cancelarCheckout(string $id)
    {
        return $this->apiClient->post("checkouts/{$id}/cancel");
    }
    
}

  