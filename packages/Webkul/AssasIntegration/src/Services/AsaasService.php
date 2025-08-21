<?php

namespace Ds\AssasIntegration\Services;

class AsaasService
{
    protected $apiClient;
    protected $cobranca;
    protected $cliente;
    protected $assinatura;
    protected $notificacao;
    protected $transferencia;
    protected $webhook;
    protected $pix;
    protected $pixRecorrente;
    protected $transacoesPix;
    protected $cartaoCredito;
    protected $parcelamento;
    protected $estorno;
    protected $contaBancaria;
    protected $linkPagamento;
    protected $checkout;
    protected $splits;
    protected $antecipacoes;
    protected $negativacoes;
    protected $extrato;
    protected $recargaCelular;
    protected $pagamentoContas;
    protected $notaFiscal;
    protected $informacoesFiscais;
    protected $informacoesFinanceiras;
    protected $personalizarConta;
    protected $subcontas;
    protected $contaEscrow;
    protected $documentoCobranca;
    protected $cobrancaDadosResumidos;
    protected $chargeBack;
    protected $consultaSerasa;
    protected $envioDocumentoWhiteLabel;

    public function __construct(
        ApiClientService $apiClient,
        CobrancaService $cobranca,
        ClienteService $cliente,
        AssinaturaService $assinatura,
        NotificacaoService $notificacao,
        TransferenciaService $transferencia,
        WebhookService $webhook,
        PixService $pix,
        PixRecorrenteService $pixRecorrente,
        TransacoesPixService $transacoesPix,
        CartaoDeCreditoService $cartaoCredito,
        ParcelamentoService $parcelamento,
        EstornoService $estorno,
        ContaBancariaService $contaBancaria,
        LinkDePagamentoService $linkPagamento,
        CheckoutService $checkout,
        SplitsService $splits,
        AntecipacoesService $antecipacoes,
        NegativacoesService $negativacoes,
        ExtratoService $extrato,
        RecargaDeCelularService $recargaCelular,
        PagamentoDeContasService $pagamentoContas,
        NotaFiscalService $notaFiscal,
        InformacoesFiscaisService $informacoesFiscais,
        InformacoesFinanceirasService $informacoesFinanceiras,
        PersonalizarContaService $personalizarConta,
        SubcontasService $subcontas,
        ContaEscrowService $contaEscrow,
        DocumentoDeCobrancaService $documentoCobranca,
        CobrancaDadosResumidosService $cobrancaDadosResumidos,
        ChargeBackService $chargeBack,
        ConsultaSerasaService $consultaSerasa,
        EnvioDeDocumentoWhiteLabelService $envioDocumentoWhiteLabel
    ) {
        $this->apiClient = $apiClient;
        $this->cobranca = $cobranca;
        $this->cliente = $cliente;
        $this->assinatura = $assinatura;
        $this->notificacao = $notificacao;
        $this->transferencia = $transferencia;
        $this->webhook = $webhook;
        $this->pix = $pix;
        $this->pixRecorrente = $pixRecorrente;
        $this->transacoesPix = $transacoesPix;
        $this->cartaoCredito = $cartaoCredito;
        $this->parcelamento = $parcelamento;
        $this->estorno = $estorno;
        $this->contaBancaria = $contaBancaria;
        $this->linkPagamento = $linkPagamento;
        $this->checkout = $checkout;
        $this->splits = $splits;
        $this->antecipacoes = $antecipacoes;
        $this->negativacoes = $negativacoes;
        $this->extrato = $extrato;
        $this->recargaCelular = $recargaCelular;
        $this->pagamentoContas = $pagamentoContas;
        $this->notaFiscal = $notaFiscal;
        $this->informacoesFiscais = $informacoesFiscais;
        $this->informacoesFinanceiras = $informacoesFinanceiras;
        $this->personalizarConta = $personalizarConta;
        $this->subcontas = $subcontas;
        $this->contaEscrow = $contaEscrow;
        $this->documentoCobranca = $documentoCobranca;
        $this->cobrancaDadosResumidos = $cobrancaDadosResumidos;
        $this->chargeBack = $chargeBack;
        $this->consultaSerasa = $consultaSerasa;
        $this->envioDocumentoWhiteLabel = $envioDocumentoWhiteLabel;
    }

    /**
     * Acessar serviço de API Client
     */
    public function api(): ApiClientService
    {
        return $this->apiClient;
    }

    /**
     * Acessar serviço de cobranças
     */
    public function cobranca(): CobrancaService
    {
        return $this->cobranca;
    }

    /**
     * Acessar serviço de clientes
     */
    public function cliente(): ClienteService
    {
        return $this->cliente;
    }

    /**
     * Acessar serviço de assinaturas
     */
    public function assinatura(): AssinaturaService
    {
        return $this->assinatura;
    }

    /**
     * Acessar serviço de notificações
     */
    public function notificacao(): NotificacaoService
    {
        return $this->notificacao;
    }

    /**
     * Acessar serviço de transferências
     */
    public function transferencia(): TransferenciaService
    {
        return $this->transferencia;
    }

    /**
     * Acessar serviço de webhooks
     */
    public function webhook(): WebhookService
    {
        return $this->webhook;
    }

    /**
     * Acessar serviço de PIX
     */
    public function pix(): PixService
    {
        return $this->pix;
    }

    /**
     * Acessar serviço de PIX recorrente
     */
    public function pixRecorrente(): PixRecorrenteService
    {
        return $this->pixRecorrente;
    }

    /**
     * Acessar serviço de transações PIX
     */
    public function transacoesPix(): TransacoesPixService
    {
        return $this->transacoesPix;
    }

    /**
     * Acessar serviço de cartão de crédito
     */
    public function cartaoCredito(): CartaoDeCreditoService
    {
        return $this->cartaoCredito;
    }

    /**
     * Acessar serviço de parcelamento
     */
    public function parcelamento(): ParcelamentoService
    {
        return $this->parcelamento;
    }

    /**
     * Acessar serviço de estornos
     */
    public function estorno(): EstornoService
    {
        return $this->estorno;
    }

    /**
     * Acessar serviço de contas bancárias
     */
    public function contaBancaria(): ContaBancariaService
    {
        return $this->contaBancaria;
    }

    /**
     * Acessar serviço de link de pagamento
     */
    public function linkPagamento(): LinkDePagamentoService
    {
        return $this->linkPagamento;
    }

    /**
     * Acessar serviço de checkout
     */
    public function checkout(): CheckoutService
    {
        return $this->checkout;
    }

    /**
     * Acessar serviço de splits
     */
    public function splits(): SplitsService
    {
        return $this->splits;
    }

    /**
     * Acessar serviço de antecipações
     */
    public function antecipacoes(): AntecipacoesService
    {
        return $this->antecipacoes;
    }

    /**
     * Acessar serviço de negativações
     */
    public function negativacoes(): NegativacoesService
    {
        return $this->negativacoes;
    }

    /**
     * Acessar serviço de extrato
     */
    public function extrato(): ExtratoService
    {
        return $this->extrato;
    }

    /**
     * Acessar serviço de recarga de celular
     */
    public function recargaCelular(): RecargaDeCelularService
    {
        return $this->recargaCelular;
    }

    /**
     * Acessar serviço de pagamento de contas
     */
    public function pagamentoContas(): PagamentoDeContasService
    {
        return $this->pagamentoContas;
    }

    /**
     * Acessar serviço de nota fiscal
     */
    public function notaFiscal(): NotaFiscalService
    {
        return $this->notaFiscal;
    }

    /**
     * Acessar serviço de informações fiscais
     */
    public function informacoesFiscais(): InformacoesFiscaisService
    {
        return $this->informacoesFiscais;
    }

    /**
     * Acessar serviço de informações financeiras
     */
    public function informacoesFinanceiras(): InformacoesFinanceirasService
    {
        return $this->informacoesFinanceiras;
    }

    /**
     * Acessar serviço de personalizar conta
     */
    public function personalizarConta(): PersonalizarContaService
    {
        return $this->personalizarConta;
    }

    /**
     * Acessar serviço de subcontas
     */
    public function subcontas(): SubcontasService
    {
        return $this->subcontas;
    }

    /**
     * Acessar serviço de conta escrow
     */
    public function contaEscrow(): ContaEscrowService
    {
        return $this->contaEscrow;
    }

    /**
     * Acessar serviço de documento de cobrança
     */
    public function documentoCobranca(): DocumentoDeCobrancaService
    {
        return $this->documentoCobranca;
    }

    /**
     * Acessar serviço de cobrança dados resumidos
     */
    public function cobrancaDadosResumidos(): CobrancaDadosResumidosService
    {
        return $this->cobrancaDadosResumidos;
    }

    /**
     * Acessar serviço de chargeback
     */
    public function chargeBack(): ChargeBackService
    {
        return $this->chargeBack;
    }

    /**
     * Acessar serviço de consulta Serasa
     */
    public function consultaSerasa(): ConsultaSerasaService
    {
        return $this->consultaSerasa;
    }

    /**
     * Acessar serviço de envio de documento white label
     */
    public function envioDocumentoWhiteLabel(): EnvioDeDocumentoWhiteLabelService
    {
        return $this->envioDocumentoWhiteLabel;
    }
}
