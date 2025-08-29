<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Tests\TestCase;
use Ds\AssasIntegration\Services\TransferenciaService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço TransferenciaService 
// php artisan test tests/Integration/TransferenciaServiceTest.php

class TransferenciaServiceTest extends TestCase
{
    protected $apiClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
    }

    /** @test */
    public function criar_transferencia_pix_para_chave_bacen()
    {
        $service = new TransferenciaService($this->apiClient);

        // Usando chave PIX fictícia do BACEN conforme documentação
        $dados = [
            'value' => 10.00,
            'pixAddressKey' => 'cliente-a00001@pix.bcb.gov.br', // Chave fictícia do BACEN
            'pixAddressKeyType' => 'EMAIL',
            'description' => 'Teste de transferência PIX para chave BACEN',
            'operationType' => 'PIX'
        ];

        $response = $service->criarTransferencia($dados);

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('value', $response);
        $this->assertArrayHasKey('status', $response);

        return [
            'transferenciaId' => $response['id'],
            'status' => $response['status']
        ];
    }

    /**
     * @test
     * @depends criar_transferencia_pix_para_chave_bacen
     */
    public function buscar_transferencia_pix($dados)
    {
        $service = new TransferenciaService($this->apiClient);

        $transferenciaId = $dados['transferenciaId'];

        // Busca a transferência criada
        $response = $service->buscarTransferencia($transferenciaId);

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($transferenciaId, $response['id']);
        $this->assertArrayHasKey('bankAccount', $response);
        $this->assertArrayHasKey('pixAddressKey', $response['bankAccount']);
        $this->assertEquals('cliente-a00001@pix.bcb.gov.br', $response['bankAccount']['pixAddressKey']);

        return $dados;
    }

   

    /**
     * @test
     * @depends criar_transferencia_pix_para_chave_bacen
     */
    public function cancelar_transferencia_pix($dados)
    {
        $service = new TransferenciaService($this->apiClient);

        $transferenciaId = $dados['transferenciaId'];

        // Cancela a transferência criada
        $response = $service->cancelarTransferencia($transferenciaId);

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
    }

    /** @test */
    public function listar_transferencias()
    {
        $service = new TransferenciaService($this->apiClient);

        // Filtros conforme a documentação da API Asaas
        $filtros = [
            'limit' => 20,
            'offset' => 0,
            'dateCreated[ge]' => date('Y-m-d', strtotime('-30 days')), // Últimos 30 dias
            'dateCreated[le]' => date('Y-m-d'), // Hoje
            'type' => 'PIX' // Filtrar apenas transferências PIX
        ];

        $response = $service->listarTransferencias($filtros);

     

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('totalCount', $response);
    }

    
    

    /** @test */
    public function criar_transferencia_agendada()
    {
        $service = new TransferenciaService($this->apiClient);

        // Transferência agendada para amanhã
        $dados = [
            'value' => 50.00,
            'pixAddressKey' => 'cliente-a00003@pix.bcb.gov.br',
            'pixAddressKeyType' => 'EMAIL',
            'description' => 'Teste de transferência PIX agendada',
            'operationType' => 'PIX',
            'scheduleDate' => date('Y-m-d', strtotime('+1 day'))
        ];

        $response = $service->criarTransferencia($dados);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('value', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('scheduleDate', $response);
    }
}
