<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class ClienteService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar novo cliente
     */
    public function criarCliente(array $dados)
    {
        return $this->apiClient->post("customers", $dados);
    }

    /**
     * Listar clientes
     */
    public function listarClientes(array $filtros = [])
    {
        return $this->apiClient->get("customers", $filtros);
    }

    /**
     * Buscar cliente por ID
     */
    public function buscarCliente(string $id)
    {
        return $this->apiClient->get("customers/{$id}");
    }

    /**
     * Atualizar cliente
     */
    public function atualizarCliente(string $id, array $dados)
    {
        return $this->apiClient->put("customers/{$id}", $dados);
    }

    /**
     * Remover cliente
     */
    public function removerCliente(string $id)
    {
        return $this->apiClient->delete("customers/{$id}");
    }

    /**
     * Restaurar cliente removido
     */
    public function restaurarCliente(string $id)
    {
        return $this->apiClient->post("customers/{$id}/restore");
    }
}
