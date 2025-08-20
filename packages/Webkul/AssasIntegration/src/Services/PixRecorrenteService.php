<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class PixRecorrenteService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

   /**
    * Listar recorrentes pix
    */
   public function listarRecorrentesPix(array $filtros = [])
   {
    return $this->apiClient->get("pix/transactions/recurrings", $filtros);
   }
    /**
     * Recuperar uma recorrente pix
     */
    public function recuperarRecorrentePix(string $id)
    {
        return $this->apiClient->get("pix/transactions/recurrings/{$id}");
    }
    
    /**
     * Cancelar uma recorrente pix
     */
    public function cancelarRecorrentePix(string $id)
    {
        return $this->apiClient->post("pix/transactions/recurrings/{$id}/cancel");
    }

    /**
     * Listar itens de uma recorrente pix
     */
    public function listarItensDeUmaRecorrentePix(string $id)
    {
        return $this->apiClient->get("pix/transactions/recurrings/{$id}/items");
    }

    /**
     * Cancelar um item de uma recorrente pix
     */
    public function cancelarItemDeUmaRecorrentePix(string $id)
    {
        return $this->apiClient->post("pix/transactions/recurrings/items/{$id}/cancel");
    }
   
}