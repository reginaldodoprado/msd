<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class ChargeBackService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * listar chargebacks
     */
    public function listarChargebacks(array $filtros = [])
    {
        return $this->apiClient->get("chargebacks", $filtros);
    }

    /**
     * recuperar chargeback
     */
    public function recuperarChargeback(string $id)
    {
        return $this->apiClient->get("chargebacks/{$id}");
    }

    /**
     * criar disputa chargeback
     */
    public function criarDisputaChargeback(string $id, array $dados)
    {
        return $this->apiClient->post("chargebacks/{$id}/dispute", $dados);
    }

}

 

    