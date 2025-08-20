<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class InformacoesFiscaisService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Recuperar informações fiscais
     */
    public function recuperarInformacoesFiscais()
    {
        return $this->apiClient->get("fiscalInfo/");
    }

    /**
     * criar e atualizar informações fiscais
     */
    public function criarEAtualizarInformacoesFiscais(array $dados)
    {
        return $this->apiClient->post("fiscalInfo/", $dados);
    }

    /**
     * listar configs municipais
     */
    public function listarConfigsMunicipais()
    {
        return $this->apiClient->get("fiscalInfo/municipalOptions");
    }

    /**
     * listar servicos municipais
     */
    public function listarServicosMunicipais()
    {
        return $this->apiClient->get("fiscalInfo/services");
    }

    /**
     * listar codigos nbs
     */
    public function listarCodigosNbs()
    {
        return $this->apiClient->get("fiscalInfo/nbsCodes");
    }

    /**
     * config portal emissor de nota fiscal
     */
    public function configPortalEmissorDeNotaFiscal(array $dados)
    {
        return $this->apiClient->post("fiscalInfo/nationalPortal", $dados);
    }

    
    
}