<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class AntecipacoesService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Recuperar uma antecipação
     */
    public function recuperarAntecipacao(string $id)
    {
        return $this->apiClient->get("anticipations/{$id}");
    }
    
    /**
     * Solicitar uma antecipação
     */
    public function solicitarAntecipacao(array $dados)
    {
        return $this->apiClient->post("anticipations", $dados);
    }

    /**
     * Listar antecipações
     */
    public function listarAntecipacoes(array $filtros = [])
    {
        return $this->apiClient->get("anticipations", $filtros);
    }
    

    /**
     * Simular uma antecipação
     */
    public function simularAntecipacao(array $dados)
    {
        return $this->apiClient->post("anticipations/simulate", $dados);
    }
    
    /**
     * Atualizar status de uma antecipação
     */
    public function atualizarStatusDeUmaAntecipacaoAutomaticamente(array $dados)
    {
        return $this->apiClient->put("anticipations/configurations", $dados);
    }

    /**
     * Recuperar status de uma antecipação automática
     */
    public function recuperarStatusDeUmaAntecipacaoAutomatica()
    {
        return $this->apiClient->get("anticipations/configurations");
    }

    /**
     * Recuperar limite de antecipação
     */
    public function recuperarLimiteDeAntecipacao()
    {
        return $this->apiClient->get("anticipations/limits");
    }
    

    /**
     * Cancelar uma antecipação
     */
    public function cancelarAntecipacao(string $id)
    {
        return $this->apiClient->post("anticipations/{$id}/cancel");
    }
    
}
