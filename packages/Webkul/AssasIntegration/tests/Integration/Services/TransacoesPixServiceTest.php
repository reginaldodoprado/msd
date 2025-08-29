<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\TransacoesPixService;
use Ds\AssasIntegration\Services\PixService;
use Ds\AssasIntegration\Tests\TestCase;

class TransacoesPixServiceTest extends TestCase
{
    protected $apiClient;
    protected $transacoesPixService;
    protected $pixService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->transacoesPixService = new TransacoesPixService($this->apiClient);
        $this->pixService = new PixService($this->apiClient);
    }

    /** @test */
    public function criar_chave_pix_para_teste()
    {
        // Criar uma chave PIX primeiro (conforme PixServiceTest)
        $dadosChave = [
            'type' => 'EVP' // Chave aleatória (único campo obrigatório)
        ];

        $response = $this->pixService->criarChavePix($dadosChave);

        dump('RESPOSTA CRIAR CHAVE PIX:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('key', $response);
        $this->assertArrayHasKey('type', $response);

        return [
            'chaveId' => $response['id'],
            'chavePix' => $response['key']
        ];
    }

    /**
     * @test
     * @depends criar_chave_pix_para_teste
     */
    public function criar_qr_code_estatico_para_teste($dadosChave)
    {
        // Criar um QR Code estático conforme PixServiceTest
        $dadosQrCode = [
            'addressKey' => $dadosChave['chavePix'], // Chave PIX válida
            'value' => 10.50,
            'description' => 'QR Code de Teste',
            'format' => 'ALL',
            'allowsMultiplePayments' => true
        ];

        $response = $this->pixService->criarQrCodeEstatico($dadosQrCode);

        dump('RESPOSTA CRIAR QR CODE ESTÁTICO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('encodedImage', $response);
        $this->assertArrayHasKey('payload', $response);

        return [
            'qrCodeId' => $response['id'],
            'qrCodePayload' => $response['payload'],
            'chaveId' => $dadosChave['chaveId']
        ];
    }

    /**
     * @test
     * @depends criar_qr_code_estatico_para_teste
     */
    public function pagar_qr_code_pix($dados)
    {
        // Dados conforme a documentação da API Asaas
        $dadosPagamento = [
            'qrCode' => [
                'payload' => $dados['qrCodePayload']
            ],
            'value' => 10.50
        ];

        $response = $this->transacoesPixService->pagarQrCodePix($dadosPagamento);

        dump('RESPOSTA PAGAR QR CODE PIX:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);

        return [
            'transacaoId' => $response['id'],
            'qrCodeId' => $dados['qrCodeId'],
            'chaveId' => $dados['chaveId']
        ];
    }

    /**
     * @test
     * @depends pagar_qr_code_pix
     */
    public function recuperar_uma_unica_transacao_pix($dados)
    {
        $transacaoId = $dados['transacaoId'];

        $response = $this->transacoesPixService->recuperarUmaUnicaTransacaoPix($transacaoId);

        dump('RESPOSTA RECUPERAR TRANSAÇÃO PIX:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($transacaoId, $response['id']);
    }

    /**
     * @test
     * @depends criar_qr_code_estatico_para_teste
     */
    public function decodificar_para_pagar_qr_code_pix($dados)
    {
        $dados = [
           'payload' => $dados['qrCodePayload']
        ];

        $response = $this->transacoesPixService->decodificarParaPagarQrCodePix($dados);

        dump('RESPOSTA DECODIFICAR QR CODE PIX:', $response);

        $this->assertIsArray($response);
       
    }

    /** @test */
    public function listar_transacoes_pix()
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0
        ];

        $response = $this->transacoesPixService->listarTransacoesPix($filtros);

        dump('RESPOSTA LISTAR TRANSAÇÕES PIX:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /**
     * @test
     * @depends pagar_qr_code_pix
     */
    public function cancelar_transacao_pix_agendada($dados)
    {
        $transacaoId = $dados['transacaoId'];

        $response = $this->transacoesPixService->cancelarTransacaoPixAgendada($transacaoId);

        dump('RESPOSTA CANCELAR TRANSAÇÃO PIX AGENDADA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('CANCELLED', $response['status']);
    }

    /**
     * @test
     * @depends criar_qr_code_estatico_para_teste
     */
    public function deletar_qr_code_estatico($dados)
    {
        $qrCodeId = $dados['qrCodeId'];

        $response = $this->pixService->deletarQrCodeEstatico($qrCodeId);

        dump('RESPOSTA DELETAR QR CODE ESTÁTICO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('deleted', $response);
        $this->assertTrue($response['deleted']);
    }


}
