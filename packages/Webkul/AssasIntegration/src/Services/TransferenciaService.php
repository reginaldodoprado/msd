<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class TransferenciaService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar nova transferência
     */
    public function criarTransferencia(array $dados)
    {
        return $this->apiClient->post("transfers", $dados);
    }

    /**
     * Listar transferências
     */
    public function listarTransferencias(array $filtros = [])
    {
        return $this->apiClient->get("transfers", $filtros);
    }

    /**
     * Transferir para conta assas
     */
    public function transferirParaContaAssas(array $dados)
    {
        return $this->apiClient->post("transfers/", $dados);
    }


    /**
     * Buscar transferência por ID
     */
    public function buscarTransferencia(string $id)
    {
        return $this->apiClient->get("transfers/{$id}");
    }

    /**
     * Cancelar transferência
     */
    public function cancelarTransferencia(string $id)
    {
        return $this->apiClient->post("transfers/{$id}/cancel");
    }

   
}
