<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class AssinaturaService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar nova assinatura
     */
    public function criarAssinatura(array $dados)
    {
        return $this->apiClient->post("subscriptions", $dados);
    }

   

    /**
     * Listar assinaturas
     */
    public function listarAssinaturas(array $filtros = [])
    {
        return $this->apiClient->get("subscriptions", $filtros);
    }

     /**
     * Criar assinatura com cartão de crédito
     */
    public function criarAssinaturaComCartaoDeCredito(array $dados)
    {
        return $this->apiClient->post("subscriptions/", $dados);
    }


    /**
     * Buscar assinatura por ID
     */
    public function buscarAssinatura(string $id)
    {
        return $this->apiClient->get("subscriptions/{$id}");
    }

    /**
     * Atualizar assinatura
     */
    public function atualizarAssinatura(string $id, array $dados)
    {
        return $this->apiClient->put("subscriptions/{$id}", $dados);
    }

    /**
     * Cancelar assinatura
     */
    public function removerAssinatura(string $id)
    {
        return $this->apiClient->delete("subscriptions/{$id}");
    }

    /**
     * Atualizar cartão sem efetuar cobrança
     */
    public function atualizarCartaoSemEfetuarCobranca(string $id, array $dados)
    {
        return $this->apiClient->put("subscriptions/{$id}/creditCard", $dados);
    }

    /**
     * Listar cobranca de uma assinatura
     */
    public function listarCobrancasDeUmaAssinatura(string $id, array $filtros = [])
    {
        return $this->apiClient->get("subscriptions/{$id}/payments", $filtros);
    }

    /**
     * Gerar carne de assinatura
     */
    public function gerarCarneDeAssinatura(string $id)
    {
        return $this->apiClient->post("subscriptions/{$id}/paymentBook");

    }

    /**
     * Criar config par emissao de nota fiscal
     */
    public function criarConfiguracaoParaEmissaoDeNotaFiscal(string $id, array $dados)
    {
        return $this->apiClient->post("subscriptions/{$id}/invoicesSettings", $dados);
    }
    
    /**
     * Recuperar config par emissao de nota fiscal
     */
    public function recuperarConfiguracaoParaEmissaoDeNotaFiscal(string $id)
    {
        return $this->apiClient->get("subscriptions/{$id}/invoicesSettings");
    }

    /**
     * Remover config par emissao de nota fiscal
     */
    public function removerConfiguracaoParaEmissaoDeNotaFiscal(string $id)
    {
        return $this->apiClient->delete("subscriptions/{$id}/invoicesSettings");
    }

    /**
     * Atualizar config par emissao de nota fiscal
     */
    public function atualizarConfiguracaoParaEmissaoDeNotaFiscal(string $id, array $dados)
    {
        return $this->apiClient->put("subscriptions/{$id}/invoicesSettings", $dados);
    }

    /**
     * Listar notas fiscais de uma assinatura
     */
    public function listarNotasFiscaisDeUmaAssinatura(string $id, array $filtros = [])
    {
        return $this->apiClient->get("subscriptions/{$id}/invoices", $filtros);
    }
    
}
