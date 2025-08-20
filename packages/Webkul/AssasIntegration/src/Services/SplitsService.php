<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class SplitsService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Recuperar split pago
     */
    public function recuperarSplitPago(string $id)
    {
        return $this->apiClient->get("payments/{$id}/splits/paid");
    }

   /**
    * Listar splits pago
    */
    public function listarSplitsPago(array $filtros = [])
    {
        return $this->apiClient->get("payments/splits/paid", $filtros);
    }


    /**
     * Recuperar split recebido
     */
    public function recuperarSplitRecebido(string $id)
    {
        return $this->apiClient->get("payments/splits/received/{$id}");
    }

    /**
     * Listar splits recebido
     */
    public function listarSplitsRecebido(array $filtros = [])
    {
        return $this->apiClient->get("payments/splits/received", $filtros);
    }


}