<?php

namespace Ds\AssasIntegration\Services;     

use Ds\AssasIntegration\Services\ApiClientService;

class SubcontasService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * listar subcontas
     */
    public function listarSubcontas(array $filtros = [])
    {
        return $this->apiClient->get("accounts", $filtros);
    }

    /**
     * criar subconta
     */
    public function criarSubconta(array $dados)
    {
        return $this->apiClient->post("accounts", $dados);
    }

    /**
     * recuperar subconta
     */
    public function recuperarSubconta(string $id)
    {
        return $this->apiClient->get("accounts/{$id}");
    }

    /**
     * salvar ou atualizar config da conta escrow para subconta
     */
    public function salvarOuAtualizarConfigDaContaEscrowParaSubconta(string $id, array $dados)
    {
        return $this->apiClient->post("accounts/{$id}/escrow", $dados);
    }
    
    /**
     * recuperar config da conta escrow para subconta
     */
    public function recuperarConfigDaContaEscrowParaSubconta(string $id)
    {
        return $this->apiClient->get("accounts/{$id}/escrow");
    }

}
    
    
    