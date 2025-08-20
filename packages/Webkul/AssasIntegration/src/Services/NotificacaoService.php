<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class NotificacaoService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }


  

    /**
     * Atualizar notificação
     */
    public function atualizarNotificacao(string $id, array $dados)
    {
        return $this->apiClient->post("notifications/{$id}", $dados);
    }

    /**
     * Atualizar em lote
     */
    public function atualizarEmLote(array $dados)
    {
        return $this->apiClient->post("notifications/batch", $dados);
    }


    /**
     * Recuperar notificação de um cliente
     */
    public function recuperarNotificacaoDeUmCliente(string $id)
    {
        return $this->apiClient->get("customers/{$id}/notifications");
    }
  
}
