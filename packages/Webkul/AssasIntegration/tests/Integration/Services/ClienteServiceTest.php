<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\ClienteService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço ClienteService 
// php artisan test tests/Integration/ClienteServiceTest.php

class ClienteServiceTest extends TestCase
{
    protected $apiClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
    }

    /** @test */
    public function criar_cliente()
    {
        $service = new ClienteService($this->apiClient);

        $dados = [
            'name' => 'teste',
            'email' => 'juan@dsaplicativos.com.br',
            'phone' => '11994152001',
            'cpfCnpj' => '24971563792',
            'postalCode' => '07145100',
            'addressNumber' => '123',
            'addressComplement' => 'Apto 1'
        ];

        $response = $service->criarCliente($dados);

        dump('RESPOSTA CRIAR CLIENTE:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('email', $response);
        $this->assertArrayHasKey('cpfCnpj', $response);
        $this->assertEquals('teste', $response['name']);

        return $response['id'];
    }

    /** @test */
    public function listar_clientes()
    {
        $service = new ClienteService($this->apiClient);

        $filtros = [
            'limit' => 20,
            'offset' => 0
        ];

        $response = $service->listarClientes($filtros);

        dump('RESPOSTA LISTAR CLIENTES:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('totalCount', $response);
        $this->assertArrayHasKey('limit', $response);
        $this->assertArrayHasKey('offset', $response);
    }
/**
     * @test
     * @depends criar_cliente
     */
    public function buscar_cliente_por_id($clienteId)

    {
        $service = new ClienteService($this->apiClient);

    
        // Agora busca os detalhes desse cliente
        $response = $service->buscarCliente($clienteId);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($clienteId, $response['id']);
    }

   /**
     * @test
     * @depends criar_cliente
     */
    public function atualizar_cliente($clienteId)
    {
        $service = new ClienteService($this->apiClient);

      

        // Agora atualiza o cliente
        $dadosAtualizados = [
            'name' => 'teste2',
            'phone' => '11994152001'
        ];

        $response = $service->atualizarCliente($clienteId, $dadosAtualizados);

        dump('RESPOSTA ATUALIZAR CLIENTE:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($clienteId, $response['id']);
       
    }
    
     /**
     * @test
     * @depends criar_cliente
     */
    public function remover_cliente($clienteId)
    {
        $service = new ClienteService($this->apiClient);

     

        // Agora remove o cliente
        $response = $service->removerCliente($clienteId);

        dump('RESPOSTA REMOVER CLIENTE:', $response);

        $this->assertIsArray($response);
    }
   
}
