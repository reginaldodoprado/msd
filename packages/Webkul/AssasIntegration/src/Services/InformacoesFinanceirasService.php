<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class InformacoesFinanceirasService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Recuperar saldo da conta
     */
    public function recuperarSaldoDaConta()
    {
        return $this->apiClient->get("finance/balance");
    }

    /**
     * Recuperar estatisticas de cobranças
     */
    public function recuperarEstatisticasDeCobrancas()
    {
        return $this->apiClient->get("finance/payment/statistics");
    }

    /**
     * Recuperar valores de split
     */
    public function recuperarValoresDeSplit()
    {
        return $this->apiClient->get("finance/split/statistics");
    }

   
}