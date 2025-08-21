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
            'name' => 'João Silva',
            'email' => 'joao.silva@email.com',
            'phone' => '4799376637',
            'cpfCnpj' => '24971563792',
            'postalCode' => '12345-678',
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
        $this->assertEquals('João Silva', $response['name']);

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

    /** @test */
    public function buscar_cliente_por_id()
    {
        $service = new ClienteService($this->apiClient);

        // Primeiro lista os clientes para pegar um ID real
        $filtros = [
            'limit' => 1,
            'offset' => 0
        ];

        $listaClientes = $service->listarClientes($filtros);
        
        $this->assertIsArray($listaClientes);
        $this->assertArrayHasKey('data', $listaClientes);
        $this->assertNotEmpty($listaClientes['data']);

        // Pega o ID do primeiro cliente encontrado
        $clienteId = $listaClientes['data'][0]['id'];

        // Agora busca os detalhes desse cliente
        $response = $service->buscarCliente($clienteId);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($clienteId, $response['id']);
    }

    /** @test */
    public function atualizar_cliente()
    {
        $service = new ClienteService($this->apiClient);

        // Primeiro cria um cliente para atualizar
        $dados = [
            'name' => 'Maria Santos',
            'email' => 'maria.santos@email.com',
            'phone' => '11888888888',
            'cpfCnpj' => '24971563792'
        ];

        $cliente = $service->criarCliente($dados);
        $clienteId = $cliente['id'];

        // Agora atualiza o cliente
        $dadosAtualizados = [
            'name' => 'Maria Santos Silva',
            'phone' => '11777777777'
        ];

        $response = $service->atualizarCliente($clienteId, $dadosAtualizados);

        dump('RESPOSTA ATUALIZAR CLIENTE:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($clienteId, $response['id']);
        $this->assertEquals('Maria Santos Silva', $response['name']);
        $this->assertEquals('11777777777', $response['phone']);
    }

    /** @test */
    public function remover_cliente()
    {
        $service = new ClienteService($this->apiClient);

        // Primeiro cria um cliente para remover
        $dados = [
            'name' => 'Pedro Costa',
            'email' => 'pedro.costa@email.com',
            'phone' => '4799376637',
            'cpfCnpj' => '24971563792'
        ];

        $cliente = $service->criarCliente($dados);
        $clienteId = $cliente['id'];

        // Agora remove o cliente
        $response = $service->removerCliente($clienteId);

        dump('RESPOSTA REMOVER CLIENTE:', $response);

        $this->assertIsArray($response);
    }
}
