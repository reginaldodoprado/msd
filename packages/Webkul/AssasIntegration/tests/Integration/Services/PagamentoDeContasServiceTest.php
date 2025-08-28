<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\PagamentoDeContasService;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Tests\TestCase;

class PagamentoDeContasServiceTest extends TestCase
{
    protected $apiClient;
    protected $pagamentoContasService;
    protected $cobrancaService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->pagamentoContasService = new PagamentoDeContasService($this->apiClient);
        $this->cobrancaService = new CobrancaService($this->apiClient);
    }

    /** @test */
    public function criar_boleto_para_teste()
    {
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 29.90,
            'dueDate' => date('Y-m-d', strtotime('+5 days')),
            'description' => 'Boleto de teste para PagamentoDeContasService'
        ];

        $response = $this->cobrancaService->criarNovaCobranca($dados);

    

    

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        
        // Obtém a linha digitável usando o método específico
        $obterLinhaDigitavel = $this->cobrancaService->obterLinhaDigitavelDoBoleto($response['id']);
        $linhaDigitavel = $obterLinhaDigitavel['identificationField'];

        return $linhaDigitavel; // Retorna a linha digitável
    }

    /**
     * @test
     * @depends criar_boleto_para_teste
     */
    public function criar_pagamento_de_conta($linhaDigitavel)
    {
        $dados = [
            'identificationField' => $linhaDigitavel, // Linha digitável do boleto criado
            'description' => 'Pagamento de conta de energia de teste'
        ];

        $response = $this->pagamentoContasService->criarPagamentoDeConta($dados);

     

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);

        return $response['id'];
    }

    /**
     * @test
     * @depends criar_pagamento_de_conta
     */
    public function listar_pagamento_de_conta($pagamentoId)
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0,
            'status' => 'PENDING'
        ];

        $response = $this->pagamentoContasService->listarPagamentoDeConta($filtros);

      

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /**
     * @test
     * @depends criar_boleto_para_teste
     */
    public function simular_pagamento_de_conta($linhaDigitavel)
    {
        $dados = [
            'identificationField' => $linhaDigitavel // Linha digitável do boleto criado
        ];

        $response = $this->pagamentoContasService->simularPagamentoDeConta($dados);

      

        $this->assertIsArray($response);
        
        // Se retornar erro, pode ser que não tenha permissão no sandbox
        if (isset($response['errors'])) {
            $this->markTestSkipped('API retornou erro - possível limitação do sandbox: ' . $response['errors'][0]['description']);
            return;
        }
        
        // Verifica se tem pelo menos um dos campos esperados
        $this->assertTrue(
            isset($response['billValue']) || 
            isset($response['identificationField']) || 
            isset($response['barCode']),
            'Resposta deve conter pelo menos um campo válido'
        );
    }

    /**
     * @test
     * @depends criar_pagamento_de_conta
     */
    public function recuperar_pagamento_de_conta($pagamentoId)
    {
        $response = $this->pagamentoContasService->recuperarPagamentoDeConta($pagamentoId);

   

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($pagamentoId, $response['id']);
        
        return $pagamentoId; // Retorna o ID para o próximo teste
    }

    /**
     * @test
     * @depends recuperar_pagamento_de_conta
     */
    public function cancelar_pagamento_de_conta($pagamentoId)
    {
        $response = $this->pagamentoContasService->cancelarPagamentoDeConta($pagamentoId);

    

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('CANCELLED', $response['status']);
    }
}
