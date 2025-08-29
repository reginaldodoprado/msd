<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class PersonalizarContaService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Recuperar informações da conta
     */
    public function recuperarDadosComerciais()
    {
        return $this->apiClient->get("myAccount/commercialInfo");
    }

    /**
     * Atualizar dados comerciais
     */
    public function atualizarDadosComerciais(array $dados)
    {
        return $this->apiClient->post("myAccount/commercialInfo/", $dados);
    }

    /**
     * Salvar personalização da fatura
     */
    public function salvarPersonalizacaoDaFatura(array $dados)
    {
        return $this->apiClient->post("myAccount/paymentCheckoutConfig/", $dados);
    }

    /**
     * Recuperar personalização da fatura
     */
    public function recuperarPersonalizacaoDaFatura()
    {
        return $this->apiClient->get("myAccount/paymentCheckoutConfig/");
    }

    /**
     * recupera numero de conta
     */
    public function recuperarNumeroDeConta()
    {
        return $this->apiClient->get("myAccount/accountNumber");
    }

    /**
     * recupera taxas da conta  
     */
    public function recuperarTaxasDaConta()
    {
        return $this->apiClient->get("myAccount/fees/");
    }
    
    /**
     * consutar situacao cadastral
     */
    public function consultarSituacaoCadastral()
    {
        return $this->apiClient->get("myAccount/status/");
    }
    
    /**
     * reucperar wallet
     */
    public function recuperarWallet()
    {
        return $this->apiClient->get("wallets/");
    }

    /**
     * excluir subconta
     */
    public function excluirSubconta(array $filtros = [])
    {
        return $this->apiClient->delete("myAccount/", $filtros);
    }
    
    
    
}