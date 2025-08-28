<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class LinkDePagamentoService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar um link de pagamento
     */
    public function criarLinkDePagamento(array $dados)
    {
        return $this->apiClient->post("paymentLinks", $dados);
    }

    /**
     * Listar links de pagamento
     */
    public function listarLinksDePagamento(array $filtros = [])
    {
        return $this->apiClient->get("paymentLinks", $filtros);
    }

    /**
     * Atualizar um link de pagamento
     */
    public function atualizarLinkDePagamento(string $id, array $dados)
    {
        return $this->apiClient->put("paymentLinks/{$id}", $dados);
    }

    /**
     * Recuperar um link de pagamento
     */
    public function recuperarLinkDePagamento(string $id)
    {
        return $this->apiClient->get("paymentLinks/{$id}");
    }

    /**
     * Remover um link de pagamento
     */
    public function removerLinkDePagamento(string $id)
    {
        return $this->apiClient->delete("paymentLinks/{$id}");
    }

    /**
     * Restaurar um link de pagamento
     */
    public function restaurarLinkDePagamento(string $id)
    {
        return $this->apiClient->post("paymentLinks/{$id}/restore");
    }

    /**
     * Adicionar uma imagem ao link de pagamento
     */
    public function adicionarImagemAoLinkDePagamento(string $id, array $dados)
    {
        return $this->apiClient->post("paymentLinks/{$id}/images", $dados);
    }

  /**
   * Listar imagens de um link de pagamento
   */
  public function listarImagensDeUmLinkDePagamento(string $id)
  {
    return $this->apiClient->get("paymentLinks/{$id}/images");
  }

  /**
   * Recuperar uma imagem de um link de pagamento
   */
  public function recuperarImagemDeUmLinkDePagamento(string $id, string $imagemId)
  {
    return $this->apiClient->get("paymentLinks/{$id}/images/{$imagemId}");
  }

  /**
   * Remover uma imagem de um link de pagamento
   */
  public function removerImagemDeUmLinkDePagamento(string $id, string $imagemId)
  {
    return $this->apiClient->delete("paymentLinks/{$id}/images/{$imagemId}");
  }
    
  /**
   * Definir imagem principal de um link de pagamento
   */
  public function definirImagemPrincipalDeUmLinkDePagamento(string $id, string $imagemId)
  {
    return $this->apiClient->post("paymentLinks/{$id}/images/{$imagemId}/setAsMain");
  }

  

}
    
    