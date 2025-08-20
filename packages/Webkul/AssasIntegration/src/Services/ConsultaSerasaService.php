<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class ConsultaSerasaService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Consultar Serasa
     */
    public function consultarSerasa(array $dados)
    {
        return $this->apiClient->post("creditBureauReport", $dados);
    }

    /**
     * Listar consultas Serasa
     */
    public function listarConsultasSerasa(array $filtros = [])
    {
        return $this->apiClient->get("creditBureauReport", $filtros);
    }

    /**
     * Recuperar consulta Serasa
     */
    public function recuperarConsultaSerasa(string $id)
    {
        return $this->apiClient->get("creditBureauReport/{$id}");
    }

  
}
