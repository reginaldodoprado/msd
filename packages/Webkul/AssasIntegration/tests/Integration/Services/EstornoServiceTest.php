<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\EstornoService;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Services\ParcelamentoService;
use Ds\AssasIntegration\Services\ApiClientService;


// teste individual do serviço EstornoService 
// php artisan test tests/Integration/EstornoServiceTest.php

class EstornoServiceTest extends TestCase
{
    protected $apiClient;
    protected $cobrancaService;
    protected $parcelamentoService;
    protected $estornoService;
    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
        $this->cobrancaService = new CobrancaService($this->apiClient);
        $this->parcelamentoService = new ParcelamentoService($this->apiClient);
        $this->estornoService = new EstornoService($this->apiClient);
    }
    /** @test */
    public function criar_parcelamento_para_estorno()
    {
        $dados = [
            'customer' => 'cus_000006963164',
            'installmentCount' => 12,
            'value' => 50.00,
            'totalValue' => 600.00,
            'billingType' => 'CREDIT_CARD',
            'dueDate' => '2025-12-31',
            'description' => 'Parcelamento com cartão em 12x',
            'creditCard' => [
                'holderName' => 'João Silva',
                'number' => '4111111111111111',
                'expiryMonth' => '12',
                'expiryYear' => '2025',
                'ccv' => '123'
            ],
            'creditCardHolderInfo' => [
                'name' => 'João Silva',
                'email' => 'joao.silva@teste.com',
                'cpfCnpj' => '12345678909',
                'phone' => '11987654321',
                'postalCode' => '07145100',
                'addressNumber' => '123',
                'addressComplement' => 'Apto 45',
                'mobilePhone' => '11987654321'
            ]
        ];

        $parcelamento = $this->parcelamentoService->criarParcelamentoComCartaoDeCredito($dados);
      
       

        dump('RESPOSTA CRIAR PARCELAMENTO PARA ESTORNO:', $parcelamento);

        $this->assertIsArray($parcelamento);
        $this->assertArrayHasKey('id', $parcelamento);

        return $parcelamento['id'];
    }

 

  /**
   * @test
 
   */
    public function estornar_boleto()
    {

        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de estorno de boleto',
        ];



        $cobranca = $this->cobrancaService->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

         $this->cobrancaService->confirmarPagamentoEmSandbox($cobrancaId);

        // Aguarda 10 segundos para o pagamento ser confirmado
        sleep(10);

        $response = $this->estornoService->estornarBoleto($cobrancaId);

        dump('RESPOSTA ESTORNAR BOLETO:', $response);

     

        $this->assertIsArray($response);
        

    }

    /**
     * @test
     * 
     */
    public function estornar_parcelamento()
    {   

        $dados = [
            'customer' => 'cus_000006963164',
            'installmentCount' => 12,
            'value' => 50.00,
            'totalValue' => 600.00,
            'billingType' => 'CREDIT_CARD',
            'dueDate' => '2025-12-31',
            'description' => 'Parcelamento com cartão em 12x',
            'creditCard' => [
                'holderName' => 'João Silva',
                'number' => '4111111111111111',
                'expiryMonth' => '12',
                'expiryYear' => '2025',
                'ccv' => '123'
            ],
            'creditCardHolderInfo' => [
                'name' => 'João Silva',
                'email' => 'joao.silva@teste.com',
                'cpfCnpj' => '12345678909',
                'phone' => '11987654321',
                'postalCode' => '07145100',
                'addressNumber' => '123',
                'addressComplement' => 'Apto 45',
                'mobilePhone' => '11987654321'
            ]
        ];

        $parcelamento = $this->parcelamentoService->criarParcelamentoComCartaoDeCredito($dados);
        $parcelamentoId = $parcelamento['id'];

     

        $this->cobrancaService->confirmarPagamentoEmSandbox($parcelamentoId);

        // Aguarda 10 segundos para o pagamento ser confirmado
        sleep(10);

        $response = $this->estornoService->estornarParcelamento($parcelamentoId);

        dump('RESPOSTA ESTORNAR PARCELAMENTO:', $response);

     

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($parcelamentoId, $response['id']);

        return $response['id'];
    }

    /**
     * @test
     * @depends estornar_parcelamento
     */
    public function listar_estornos_da_cobranca($parcelamentoId)
    {
        // Primeiro vamos pegar um paymentId de um dos estornos do parcelamento
        $parcelamento = $this->parcelamentoService->recuperarParcelamento($parcelamentoId);
        
        // Pega o primeiro paymentId dos refunds
        $paymentId = $parcelamento['refunds'][0]['paymentId'] ?? null;
        
        if (!$paymentId) {
            $this->markTestSkipped('Nenhum paymentId encontrado para testar listar estornos');
            return;
        }

        $response = $this->estornoService->listarEstornosDaCobranca($paymentId);

        dump('RESPOSTA LISTAR ESTORNOS DA COBRANÇA:', $response);

        $this->assertIsArray($response);
        
        // A API retorna estrutura específica para listar estornos
        if (isset($response['object']) && $response['object'] === 'list') {
            // Estrutura completa com data, hasMore, totalCount
            $this->assertArrayHasKey('data', $response);
            $this->assertArrayHasKey('hasMore', $response);
            $this->assertArrayHasKey('totalCount', $response);
            $this->assertIsArray($response['data']);
        } else {
            // Array vazio quando não há estornos
            $this->assertEmpty($response);
        }
    }





   
}
