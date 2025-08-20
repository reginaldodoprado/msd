<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class ContaBancariaService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar nova conta bancária
     */
    public function criarContaBancaria(array $dados)
    {
        return $this->apiClient->post("bankAccounts", $dados);
    }

    /**
     * Listar contas bancárias
     */
    public function listarContasBancarias()
    {
        return $this->apiClient->get("bankAccounts");
    }

    /**
     * Buscar conta bancária por ID
     */
    public function buscarContaBancaria(string $id)
    {
        return $this->apiClient->get("bankAccounts/{$id}");
    }

    /**
     * Atualizar conta bancária
     */
    public function atualizarContaBancaria(string $id, array $dados)
    {
        return $this->apiClient->post("bankAccounts/{$id}", $dados);
    }

    /**
     * Remover conta bancária
     */
    public function removerContaBancaria(string $id)
    {
        return $this->apiClient->delete("bankAccounts/{$id}");
    }

    /**
     * Validar conta bancária
     */
    public function validarContaBancaria(array $dados)
    {
        return $this->apiClient->post("bankAccounts/validate", $dados);
    }
}
