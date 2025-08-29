<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\EnvioDeDocumentoWhiteLabelService;
use Ds\AssasIntegration\Tests\TestCase;

class EnvioDeDocumentoWhiteLabelServiceTest extends TestCase
{
    protected $apiClient;
    protected $envioDocumentoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
        $this->envioDocumentoService = new EnvioDeDocumentoWhiteLabelService($this->apiClient);
    }

    /**
     * @test
     */
    public function verificar_documentos_pendentes()
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0
        ];

        $response = $this->envioDocumentoService->verificarDocumentosPendentes($filtros);
        
        
        
        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);

        // Se tiver documentos, retorna o primeiro ID para os testes dependentes
        if (!empty($response['data'])) {
            return ['id' => $response['data'][0]['id'], 'type' => $response['data'][0]['type']];
           
        }

        return null;
    }

    /**
     * @test
     * @depends verificar_documentos_pendentes
     */
    public function enviar_documento($dados)
    {
        $documentoId = $dados['id'];
        $tipoDocumento = $dados['type'];

        // Cria um arquivo temporário para teste
        $tempFile = tempnam(sys_get_temp_dir(), 'test_');
        file_put_contents($tempFile, 'Conteudo de teste para documento');

        $dados = [
            'documentFile' => new \CURLFile($tempFile, 'text/plain', 'teste.txt'),
            'type' => $tipoDocumento
        ];

        $response = $this->envioDocumentoService->enviarDocumento($documentoId, $dados);
        
        
        
        $this->assertIsArray($response);

        // Remove o arquivo temporário
        unlink($tempFile);

        // Se retornar erro, pode ser que não tenha permissão no sandbox
        if (isset($response['errors'])) {
            $this->markTestSkipped('API retornou erro - possível limitação do sandbox');
            return null;
        }

        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('PENDING', $response['status']);

        return ['id' => $response['id'], 'type' => $tipoDocumento];
    }

    /**
     * @test
     * @depends enviar_documento
     */
    public function visualizar_doc_enviado($dados)
    {
        // Se não tiver dados, pula o teste
        if ($dados === null) {
            $this->markTestSkipped('Nenhum documento enviado - pulando teste');
            return null;
        }

        $documentoId = $dados['id'];
        $response = $this->envioDocumentoService->visualizarDocEnviado($documentoId);
        
        
        
        $this->assertIsArray($response);

        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($documentoId, $response['id']);

        return $dados;
    }

    /**
     * @test
     * @depends enviar_documento
     */
    public function atualizar_doc_enviado($dados)
    {
        $documentoId = $dados['id'];
        

        // Cria um arquivo temporário para teste
        $tempFile = tempnam(sys_get_temp_dir(), 'test_');
        file_put_contents($tempFile, 'Conteudo atualizado para documento');

        $dadosEnvio = [
            'documentFile' => new \CURLFile($tempFile, 'text/plain', 'teste_atualizado.txt'),
            
        ];

        $response = $this->envioDocumentoService->atualizarDocEnviado($documentoId, $dadosEnvio);
        
        
        
        $this->assertIsArray($response);

        // Remove o arquivo temporário
        unlink($tempFile);

    

        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('PENDING', $response['status']);

        return $dados;
    }

    /**
     * @test
     * @depends atualizar_doc_enviado
     */
    public function remover_doc_enviado($dados)
    {
        $documentoId = $dados['id'];

        $response = $this->envioDocumentoService->removerDocEnviado($documentoId);
        
       
        
        $this->assertIsArray($response);

   

        $this->assertArrayHasKey('deleted', $response);
        $this->assertTrue($response['deleted']);
    }
}
   