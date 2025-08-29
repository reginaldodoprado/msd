<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\PixRecorrenteService;
use Ds\AssasIntegration\Services\TransferenciaService;
use Tests\TestCase;

class PixRecorrenteServiceTest extends TestCase
{
    protected $apiClient;
    protected $pixRecorrenteService;
    protected $transferenciaService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->pixRecorrenteService = new PixRecorrenteService($this->apiClient);
        $this->transferenciaService = new TransferenciaService($this->apiClient);
    }

    /** @test */
    public function criar_transferencia_pix_recorrente_mensal()
    {
        // Usando chave PIX fictícia do BACEN conforme documentação
        $dados = [
            'value' => 25.00,
            'pixAddressKey' => 'cliente-a00001@pix.bcb.gov.br', // Chave fictícia do BACEN
            'pixAddressKeyType' => 'EMAIL',
            'description' => 'Transferência PIX recorrente mensal de teste',
            'operationType' => 'PIX',
            'recurring' => [
                'frequency' => 'MONTHLY',
                'quantity' => 3 // 3 repetições mensais
            ]
        ];

        $response = $this->transferenciaService->criarTransferencia($dados);

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('value', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('recurring', $response);

        return [
            'transferenciaId' => $response['id'],
            'status' => $response['status']
        ];
    }

 

    /** @test */
    public function listar_recorrentes_pix()
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0
        ];

        $response = $this->pixRecorrenteService->listarRecorrentesPix($filtros);

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('totalCount', $response);
        
        // Se tiver dados, retorna o primeiro ID para os testes dependentes
        if (!empty($response['data'])) {
            return $response['data'][0]['id'];
        }
        
        return null;
    }

    /**
     * @test
     * @depends listar_recorrentes_pix
     */
    public function recuperar_recorrente_pix($recorrenteId)
    {
      
        $response = $this->pixRecorrenteService->recuperarRecorrentePix($recorrenteId);

        

        $this->assertIsArray($response);
        
      
        
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($recorrenteId, $response['id']);
        
        return $recorrenteId; // Retorna o ID para os próximos testes
    }

    /**
     * @test
     * @depends recuperar_recorrente_pix
     */
    public function listar_itens_de_uma_recorrente_pix($recorrenteId)
    {
        // Se não tiver ID, pula o teste
        if ($recorrenteId === null) {
            $this->markTestSkipped('Nenhuma recorrente PIX encontrada - pulando teste');
            return null;
        }

        $response = $this->pixRecorrenteService->listarItensDeUmaRecorrentePix($recorrenteId);

      

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
        
        // Se tiver itens, retorna o segundo ID (índice 1) que pode ser cancelado
        if (!empty($response['data']) && count($response['data']) > 1) {
            return $response['data'][1]['id']; // Segundo item (índice 1)
        }
        // Se não tiver segundo item, retorna o primeiro
        if (!empty($response['data'])) {
            return $response['data'][0]['id'];
        }
        
        return null;
    }

    /**
     * @test
     * @depends listar_itens_de_uma_recorrente_pix
     */
    public function cancelar_item_de_uma_recorrente_pix($itemId)
    {
        // Se não tiver ID, pula o teste
        if ($itemId === null) {
            $this->markTestSkipped('Nenhum item de recorrente PIX encontrado - pulando teste');
            return;
        }

        $response = $this->pixRecorrenteService->cancelarItemDeUmaRecorrentePix($itemId);

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('CANCELLED', $response['status']);
    }

    /**
     * @test
     * @depends recuperar_recorrente_pix
     */
    public function cancelar_recorrente_pix($recorrenteId)
    {
        // Se não tiver ID, pula o teste
        if ($recorrenteId === null) {
            $this->markTestSkipped('Nenhuma recorrente PIX encontrada - pulando teste');
            return;
        }

        $response = $this->pixRecorrenteService->cancelarRecorrentePix($recorrenteId);

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('CANCELLED', $response['status']);
    }
}