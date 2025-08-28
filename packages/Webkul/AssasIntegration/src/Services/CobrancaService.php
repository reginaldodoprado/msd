<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class CobrancaService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Criar nova cobrança
     */
    public function criarNovaCobranca(array $dados)
    {
        return $this->apiClient->post("payments", $dados);
    }

    /**
     * Listar cobranças
     */
    public function listarCobrancas(array $filtros = [])
    {
        return $this->apiClient->get("payments", $filtros);
    }

   

    /**
     * Criar transação de crédito
     */
    public function criarCobrancaComCartaoDeCredito(array $dados)
    {
        return $this->apiClient->post("payments", $dados);
    }

    /**
     * Capturar cobranca com pre autorizacao    
     */
    public function capturarCobrancaComPreAutorizacao(string $id, array $dados)
    {
        return $this->apiClient->post("payments/{$id}/captureAuthorizedPayment", $dados);
    }


    /**
     * Pagar uma cobranca com cartao de credito
     */
    public function pagarCobrancaComCartaoDeCredito(string $id, array $dados)
    {
        return $this->apiClient->post("payments/{$id}/payWithCreditCard", $dados);
    }
  

    /**
     * Recuperar informações do pagamento de uma cobranca
     */
    public function recuperarInformacoesDoPagamento(string $id)
    {
        return $this->apiClient->get("payments/{$id}/billingInfo");
    }

    /**
     * Informacoes sobre vizualizaçao da cobranca 
     */
    public function informacoesSobreVizualizacaoDaCobranca(string $id)
    {
        return $this->apiClient->get("payments/{$id}/viewingInfo");
    }

    /**
     * Recuperar uma unica cobranca
     */
    public function recuperarUmaUnicaCobranca(string $id)
    {
        return $this->apiClient->get("payments/{$id}");
    }
    
    /**
     * Atualizar uma cobranca
     */
    public function atualizarUmaCobranca(string $id, array $dados)
    {
        return $this->apiClient->put("payments/{$id}", $dados);
    }

    /**
     * Excluir uma cobranca
     */
    public function excluirUmaCobranca(string $id)
    {
        return $this->apiClient->delete("payments/{$id}");
    }
    
    /**
     * Restaurar uma cobranca removida
     */
    public function restaurarUmaCobranca(string $id)
    {
        return $this->apiClient->post("payments/{$id}/restore");
    }

    /**
     * Recuperar status de uma cobranca
     */
    public function recuperarStatusDeUmaCobranca(string $id)
    {
        return $this->apiClient->get("payments/{$id}/status");
    }

    /**
     * Obter linha digitavel do boleto
     */
    public function obterLinhaDigitavelDoBoleto(string $id)
    {
        return $this->apiClient->get("payments/{$id}/identificationField");
    }

    /**
     * Obter qrcode para pagamento pix
     */
    public function obterQrcodeParaPagamentoPix(string $id)
    {
        return $this->apiClient->get("payments/{$id}/pixQrCode");
    }
     
    /**
     * Confirmar recebimento em dinheiro
     */
    public function confirmarRecebimentoEmDinheiro(string $id, array $dados = [])
    {
        return $this->apiClient->post("payments/{$id}/receiveInCash", $dados);
    }

    /**
     * Desfazer confirmaçao de recebimento em dinheiro
     */
    public function desfazerConfirmacaoDeRecebimentoEmDinheiro(string $id)
    {
        return $this->apiClient->post("payments/{$id}/undoReceivedInCash");
    }

    /**
     * Simular venda
     */
    public function simularVenda(array $dados)
    {
        return $this->apiClient->post("payments/simulate", $dados);
    }


    /**
     * Recuperar garantia da cobranca na conta escrow
     */
    public function recuperarGarantiaDaCobrancaNaContaEscrow(string $id)
    {
        return $this->apiClient->get("payments/{$id}/escrow");
    }

    /**
     * Recuperar limites de cobranca
     */
    public function recuperarLimitesDeCobranca()
    {
        return $this->apiClient->get("payments/limits");
    }

}


