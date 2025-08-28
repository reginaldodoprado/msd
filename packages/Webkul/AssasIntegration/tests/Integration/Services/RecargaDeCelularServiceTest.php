<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\RecargaDeCelularService;
use Tests\TestCase;

class RecargaDeCelularServiceTest extends TestCase
{
    protected $apiClient;
    protected $recargaCelularService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->recargaCelularService = new RecargaDeCelularService($this->apiClient);
    }

    /** @test */
    public function solicitar_recarga_de_celular()
    {
        $dados = [
            'value' => 20.00,
            'phoneNumber' => '11987654321'
            
           
        ];

        $response = $this->recargaCelularService->solicitarRecargaDeCelular($dados);

        dump('RESPOSTA SOLICITAR RECARGA DE CELULAR:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('phoneNumber', $response);
        $this->assertEquals('11987654321', $response['phoneNumber']);

        return $response['id'];
    }

    /** @test */
    public function listar_recargas_de_celular()
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0,
            'status' => 'PENDING'
        ];

        $response = $this->recargaCelularService->listarRecargasDeCelular($filtros);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /** 
     * @test
     * @depends solicitar_recarga_de_celular
     */
    public function recuperar_recarga_de_celular($recargaId)
    {
        // Recupera a recarga usando o ID real retornado pelo primeiro teste
        $response = $this->recargaCelularService->recuperarRecargaDeCelular($recargaId);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($recargaId, $response['id']);
    }

    /** 
     * @test
     * @depends solicitar_recarga_de_celular
     */
    public function cancelar_recarga_de_celular($recargaId)
    {
        // Cancela a recarga usando o ID real retornado pelo primeiro teste
        $response = $this->recargaCelularService->cancelarRecargaDeCelular($recargaId);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('CANCELLED', $response['status']);
    }

    /** @test */
    public function listar_valores_disponiveis_para_recarga_de_celular()
    {
        $phoneNumber = '11994152001';

        $response = $this->recargaCelularService->listarValoresDisponiveisParaRecargaDeCelular($phoneNumber);

       

        $this->assertIsArray($response);
       
    }
}
