<?php

namespace Ds\AssasIntegration\Services;

class AsaasService
{
    protected $cobranca;
    protected $cliente;
    protected $assinatura;
    protected $notificacao;
    protected $transferencia;
    protected $webhook;
    protected $relatorio;
    protected $contaBancaria;
    protected $estorno;
    protected $desconto;

    public function __construct(
        CobrancaService $cobranca,
        ClienteService $cliente,
        AssinaturaService $assinatura,
        NotificacaoService $notificacao,
        TransferenciaService $transferencia,
        WebhookService $webhook,
        RelatorioService $relatorio,
        ContaBancariaService $contaBancaria,
        EstornoService $estorno,
        DescontoService $desconto
    ) {
        $this->cobranca = $cobranca;
        $this->cliente = $cliente;
        $this->assinatura = $assinatura;
        $this->notificacao = $notificacao;
        $this->transferencia = $transferencia;
        $this->webhook = $webhook;
        $this->relatorio = $relatorio;
        $this->contaBancaria = $contaBancaria;
        $this->estorno = $estorno;
        $this->desconto = $desconto;
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
     * Acessar serviço de relatórios
     */
    public function relatorio(): RelatorioService
    {
        return $this->relatorio;
    }

    /**
     * Acessar serviço de contas bancárias
     */
    public function contaBancaria(): ContaBancariaService
    {
        return $this->contaBancaria;
    }

    /**
     * Acessar serviço de estornos
     */
    public function estorno(): EstornoService
    {
        return $this->estorno;
    }

    /**
     * Acessar serviço de descontos
     */
    public function desconto(): DescontoService
    {
        return $this->desconto;
    }
}
