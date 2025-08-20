<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class WebhookService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar novo webhook
     */
    public function criarWebhook(array $dados)
    {
        return $this->apiClient->post("webhooks", $dados);
    }

    /**
     * Listar webhooks
     */
    public function listarWebhooks()
    {
        return $this->apiClient->get("webhooks");
    }

    /**
     * Buscar webhook por ID
     */
    public function buscarWebhook(string $id)
    {
        return $this->apiClient->get("webhooks/{$id}");
    }

    /**
     * Atualizar webhook
     */
    public function atualizarWebhook(string $id, array $dados)
    {
        return $this->apiClient->post("webhooks/{$id}", $dados);
    }

    /**
     * Remover webhook
     */
    public function removerWebhook(string $id)
    {
        return $this->apiClient->delete("webhooks/{$id}");
    }

}
