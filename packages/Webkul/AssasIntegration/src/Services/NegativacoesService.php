<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class NegativacoesService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * c
     */
    public function criarNegativacao(array $dados)
    {
        return $this->apiClient->post("paymentDunnings", $dados);
    }

    /**
     * Listar negativacoes
     */
    public function listarNegativacoes(array $filtros = []) 
    {
        return $this->apiClient->get("paymentDunnings", $filtros);
    }

    /**
     * Recuperar uma negativacao
     */
    public function recuperarNegativacao(string $id)
    {
        return $this->apiClient->get("paymentDunnings/{$id}");
    }

    /**
     * Listar historico de eventos de uma negativacao
     */
    public function listarHistoricoDeEventos(string $id)
    {
        return $this->apiClient->get("paymentDunnings/{$id}/history");
    }

    /**
     * Listar pagamentos recebidos de uma negativacao
     */
    public function listarPagamentosRecebidos(string $id)
    {
        return $this->apiClient->get("paymentDunnings/{$id}/partialPayments");
    }

    /**
     * Listar cobranças disponiveis para uma negativacao
     */
    public function listarCobrasDisponiveisParaUmaNegativacao(string $id)
    {
        return $this->apiClient->get("paymentDunnings/{$id}/paymentsAvailableForDunning");
    }

   /**
    * Reenviar documento 
    */
   public function reenviarDocumento(string $id)
   {
    return $this->apiClient->post("paymentDunnings/{$id}/documents");
   }

   /**
    * Cancelar negativacao
    */
   public function cancelarNegativacao(string $id)
   {
    return $this->apiClient->post("paymentDunnings/{$id}/cancel");
   }

}
    
    