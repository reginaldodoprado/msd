<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class EnvioDeDocumentoWhiteLabelService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * verifcar documentos pendentes
     */
    public function verificarDocumentosPendentes(array $filtros = [])
    {
        return $this->apiClient->get("myAccount/documents", $filtros);
    }

    /**
     * enviar documento
     */
    public function enviarDocumento(string $id, array $dados)
    {
        return $this->apiClient->post("myAccount/documents/{$id}", $dados);
    }

    /**
     * visualizar doc envio
     */
    public function visualizarDocEnviado(string $id)
    {
        return $this->apiClient->get("myAccount/documents/files/{$id}");
    }

    /**
     * atualizar doc envio
     */
    public function atualizarDocEnviado(string $id, array $dados)
    {
        return $this->apiClient->post("myAccount/documents/files/{$id}", $dados);
    }

    /**
     * remover doc envio
     */
    public function removerDocEnviado(string $id)
    {
        return $this->apiClient->delete("myAccount/documents/files/{$id}");
    }
    
    
}    
    