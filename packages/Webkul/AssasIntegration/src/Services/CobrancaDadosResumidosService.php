<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class CobrancaDadosResumidosService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar nova cobrança resumido
     */
    public function criarNovaCobrancaResumido(array $dados)
    {
        return $this->apiClient->post("lean/payments", $dados);
    }

    /**
     * Listar cobranças resumido
     */
    public function listarCobrancasResumido(array $filtros = [])
    {
        return $this->apiClient->get("lean/payments", $filtros);
    }

   

    /**
     * Criar transação de crédito
     */
    public function criarCobrancaComCartaoDeCreditoResumido(array $dados)
    {
        return $this->apiClient->post("lean/payments", $dados);
    }

    /**
     * Capturar cobranca com pre autorizacao    
     */
    public function capturarCobrancaComPreAutorizacaoResumido(string $id, array $dados)
    {
        return $this->apiClient->post("lean/payments/{$id}/captureAuthorizedPayment", $dados);
    }


    /**
     * Recuperar uma unica cobranca resumido
     */
    public function recuperarUmaUnicaCobrancaResumido(string $id)
    {
        return $this->apiClient->get("lean/payments/{$id}");
    }
    
    /**
     * Atualizar uma cobranca
     */
    public function atualizarUmaCobrancaResumido(string $id, array $dados)
    {
        return $this->apiClient->put("lean/payments/{$id}", $dados);
    }

    /**
     * Excluir uma cobranca
     */
    public function excluirUmaCobrancaResumido(string $id)
    {
        return $this->apiClient->delete("lean/payments/{$id}");
    }
    
    /**
     * Restaurar uma cobranca removida
     */
    public function restaurarUmaCobrancaResumido(string $id)
    {
        return $this->apiClient->post("lean/payments/{$id}/restore");
    }


   
     
    /**
     * Confirmar recebimento em dinheiro
     */
    public function confirmarRecebimentoEmDinheiroResumido(string $id)
    {
        return $this->apiClient->post("lean/payments/{$id}/receiveInCash",);
    }

    /**
     * Desfazer confirmaçao de recebimento em dinheiro
     */
    public function desfazerConfirmacaoDeRecebimentoEmDinheiroResumido(string $id)
    {
        return $this->apiClient->post("lean/payments/{$id}/undoReceiveInCash");
    }


}


