<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class NotaFiscalService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }


    /**
     * agendar nota fiscal
     */
    public function agendarNotaFiscal(array $dados)
    {
        return $this->apiClient->post("invoices", $dados);
    }

    /**
     * listar notas fiscais
     */
    public function listarNotasFiscais(array $filtros = [])
    {
        return $this->apiClient->get("invoices", $filtros);
    }

    /**
     * atualizar nota fiscal
     */
    public function atualizarNotaFiscal(string $id, array $dados)
    {
        return $this->apiClient->put("invoices/{$id}", $dados);
    }

    /**
     * Recuperar nota fiscal
     */ 
    public function recuperarNotaFiscal(string $id)
    {
        return $this->apiClient->get("invoices/{$id}");
    }

    /**
     * emitir nota fiscal
     */
    public function emitirNotaFiscal(string $id)
    {
        return $this->apiClient->post("invoices/{$id}/authorize");
    }

    /**
     * cancelar nota fiscal
     */
    public function cancelarNotaFiscal(string $id)
    {
        return $this->apiClient->post("invoices/{$id}/cancel");
    }
    
  
    
}