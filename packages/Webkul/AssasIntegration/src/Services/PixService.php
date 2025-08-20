<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class PixService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar uma chave pix
     */
    public function criarChavePix(array $dados)
    {
        return $this->apiClient->post("pix/addresseKeys", $dados);
    }

    /**
     * Listar chaves pix
     */
    public function listarChavesPix(array $filtros = [])
    {
        return $this->apiClient->get("pix/addresseKeys", $filtros);
    }

    /**
     * Recuperar uma chave pix
     */
    public function recuperarChavePix(string $id)
    {
        return $this->apiClient->get("pix/addresseKeys/{$id}");
    }

    /**
     * Remover uma chave pix
     */
    public function removerChavePix(string $id)
    {
        return $this->apiClient->delete("pix/addresseKeys/{$id}");
    }

    /**
     * Criar qr code estatico
     */
    public function criarQrCodeEstatico(array $dados)
    {
        return $this->apiClient->post("pix/qrCodes/static", $dados);
    }

    /**
     * Deletar qr code estatico
     */
    public function deletarQrCodeEstatico(string $id)
    {
        return $this->apiClient->delete("pix/qrCodes/static/{$id}");
    }

    /**
     * Consulta de fichas disponiveis
     */
    public function consultarFichasDisponiveis()
    {
        return $this->apiClient->get("pix/tokenBuckets/addressKey");
    }

   
    
    
}   