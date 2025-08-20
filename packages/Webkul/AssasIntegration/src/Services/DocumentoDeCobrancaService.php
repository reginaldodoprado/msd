<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class DocumentoDeCobrancaService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Fazer upload de documento de cobranca
     */
    public function fazerUploadDeDocumentoDeCobranca(string $id, array $dados)
    {
        return $this->apiClient->post("payments/{$id}/document", $dados);
    }

    /**
     * Listar documentos de cobranca
     */
    public function listarDocumentosDeCobranca(string $id)
    {
        return $this->apiClient->get("payments/{$id}/documents");
    }

    /**
     * Atualizar documento de cobranca
     */
    public function atualizarDocumentoDeCobranca(string $id, string $documentoId, array $dados)
    {
        return $this->apiClient->put("payments/{$id}/document/{$documentoId}", $dados);
    }

    /**
     * Recuperar documento de cobranca
     */
    public function recuperarDocumentoDeCobranca(string $id, string $documentoId)
    {
        return $this->apiClient->get("payments/{$id}/document/{$documentoId}");
    }

    /**
     * Excluir documento de cobranca
     */
    public function excluirDocumentoDeCobranca(string $id, string $documentoId)
    {
        return $this->apiClient->delete("payments/{$id}/document/{$documentoId}");
    }
}