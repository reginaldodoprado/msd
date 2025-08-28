<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\PixService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço PixService 
// php artisan test tests/Integration/PixServiceTest.php

class PixServiceTest extends TestCase
{
    protected $apiClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
    }

    /** @test */
    public function criar_chave_pix()
    {
        $service = new PixService($this->apiClient);

        $dados = [
            'type' => 'EVP' // Chave aleatória (único campo obrigatório)
        ];

        $response = $service->criarChavePix($dados);

        dump('RESPOSTA CRIAR CHAVE PIX:', $response);

        $this->assertIsArray($response);
        
        
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('key', $response);
        $this->assertArrayHasKey('type', $response);
        $this->assertEquals('EVP', $response['type']);

        // Retorna tanto o ID quanto a chave para os testes dependentes
        return [
            'id' => $response['id'],
            'key' => $response['key']
        ];
    }

    /** @test */
    public function listar_chaves_pix()
    {
        $service = new PixService($this->apiClient);

        $filtros = [
            'limit' => 20,
            'offset' => 0
        ];

        $response = $service->listarChavesPix($filtros);

        dump('RESPOSTA LISTAR CHAVES PIX:', $response);

        $this->assertIsArray($response);
        
      
        
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('totalCount', $response);
    }

    /**
     * @test
     * @depends criar_chave_pix
     */
    public function recuperar_chave_pix($dadosChave)
    {
        $service = new PixService($this->apiClient);

        // Extrai o ID do array retornado pelo teste anterior
        $chaveId = $dadosChave['id'];
        
        // Recupera a chave usando o ID já criado
        $response = $service->recuperarChavePix($chaveId);

        dump('RESPOSTA RECUPERAR CHAVE PIX:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($chaveId, $response['id']);
        $this->assertArrayHasKey('key', $response);
        $this->assertArrayHasKey('type', $response);
    }

    /**
     * @test
     * @depends criar_chave_pix
     */
    public function remover_chave_pix($dadosChave)
    {
        $service = new PixService($this->apiClient);

        // Extrai o ID do array retornado pelo teste anterior
        $chaveId = $dadosChave['id'];
        
        // Remove a chave usando o ID já criado
        $response = $service->removerChavePix($chaveId);

     

        $this->assertIsArray($response);
        $this->assertArrayHasKey('deleted', $response);
        $this->assertTrue($response['deleted']);
    }

    /**
     * @test
     * @depends criar_chave_pix
     */
    public function criar_qr_code_estatico($dadosChave)
    {
        $service = new PixService($this->apiClient);

        // Extrai a chave PIX do array retornado pelo teste anterior
        $chavePix = $dadosChave['key'];

        $dados = [
            'addressKey' => $chavePix, // Chave PIX válida
            'value' => 10.50,
            'description' => 'QR Code de Teste',
            'format' => 'ALL',
            'allowsMultiplePayments' => true
        ];

        $response = $service->criarQrCodeEstatico($dados);

      

        $this->assertIsArray($response);
        
      
        
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('encodedImage', $response);
        $this->assertArrayHasKey('payload', $response);

        return $response['id'];
    }

    /**
     * @test
     * @depends criar_qr_code_estatico
     */
    public function deletar_qr_code_estatico($qrCodeId)
    {
        $service = new PixService($this->apiClient);

        // Remove o QR code usando o ID já criado
        $response = $service->deletarQrCodeEstatico($qrCodeId);

 
        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('deleted', $response);
        $this->assertTrue($response['deleted']);
    }

    /** @test */
    public function consultar_fichas_disponiveis()
    {
        $service = new PixService($this->apiClient);

        $response = $service->consultarFichasDisponiveis();

     

        $this->assertIsArray($response);
        
    }
}
