<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class RecargaDeCelularService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Solicitar recarga de celular
     */
    public function solicitarRecargaDeCelular(array $dados)
    {
        return $this->apiClient->post("mobilePhoneRecharges", $dados);
    }

    /**
     * Listar recargas de celular
     */
    public function listarRecargasDeCelular(array $filtros = [])
    {
        return $this->apiClient->get("mobilePhoneRecharges", $filtros);
    }

    /**
     * Recuperar recarga de celular
     */
    public function recuperarRecargaDeCelular(string $id)
    {
        return $this->apiClient->get("mobilePhoneRecharges/{$id}");
    }

    /**
     * Cancelar recarga de celular
     */
    public function cancelarRecargaDeCelular(string $id)
    {
        return $this->apiClient->post("mobilePhoneRecharges/{$id}/cancel");
    }

    /** lista valores disponiveis para recarga de celular
     */
    public function listarValoresDisponiveisParaRecargaDeCelular(string $phoneNumber)
    {
        return $this->apiClient->get("mobilePhoneRecharges/{$phoneNumber}/provider");
    }

   
}
