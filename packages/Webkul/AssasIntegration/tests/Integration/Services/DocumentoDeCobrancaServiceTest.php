<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\DocumentoDeCobrancaService;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Services\ApiClientService;

class DocumentoDeCobrancaServiceTest extends TestCase
{
    protected $apiClient;
    protected $cobrancaService;


    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
        $this->cobrancaService = new CobrancaService($this->apiClient);
    }

    /** @test */
    public function fazer_upload_de_documento_de_cobranca()
    {
        $service = new DocumentoDeCobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de upload de documento'
        ];

        $cobranca = $this->cobrancaService->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        // Cria um arquivo simples para teste
        $tempFile = tempnam(sys_get_temp_dir(), 'test_');
        file_put_contents($tempFile, 'Conteudo de teste para documento');

        // Agora faz upload do documento com campos obrigatórios
        $dadosDocumento = [
            'file' => new \CURLFile($tempFile, 'text/plain', 'teste.txt'),
            'availableAfterPayment' => true, // Obrigatório: disponibilizar após pagamento
            'type' => 'INVOICE', // Obrigatório: tipo do documento
            'description' => 'Documento de teste'
        ];

        $response = $service->fazerUploadDeDocumentoDeCobranca($cobrancaId, $dadosDocumento);

        // Remove o arquivo temporário
        unlink($tempFile);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);

        return [
            'documentoId' => $response['id'],
            'cobrancaId' => $cobrancaId
        ];
    }

    /**
     * @test
     * @depends fazer_upload_de_documento_de_cobranca
     */
    public function listar_documentos_de_cobranca($dados)
    {
        $service = new DocumentoDeCobrancaService($this->apiClient);

        $cobrancaId = $dados['cobrancaId'];

        $response = $service->listarDocumentosDeCobranca($cobrancaId);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
    }

    /**
     * @test
     * @depends fazer_upload_de_documento_de_cobranca
     */
    public function atualizar_documento_de_cobranca($dados)
    {
        $service = new DocumentoDeCobrancaService($this->apiClient);

        $cobrancaId = $dados['cobrancaId'];
        $documentoId = $dados['documentoId'];

        // Agora atualiza o documento
        $dadosAtualizados = [
            'description' => 'Descrição atualizada'
        ];

        $response = $service->atualizarDocumentoDeCobranca($cobrancaId, $documentoId, $dadosAtualizados);

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($documentoId, $response['id']);
    }

    /**
     * @test
     * @depends fazer_upload_de_documento_de_cobranca
     */
    public function recuperar_documento_de_cobranca($dados)
    {
        $service = new DocumentoDeCobrancaService($this->apiClient);

        $cobrancaId = $dados['cobrancaId'];
        $documentoId = $dados['documentoId'];

        // Agora recupera o documento
        $response = $service->recuperarDocumentoDeCobranca($cobrancaId, $documentoId);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($documentoId, $response['id']);
    }

    /**
     * @test
     * @depends fazer_upload_de_documento_de_cobranca
     */
    public function excluir_documento_de_cobranca($dados)
    {
        $service = new DocumentoDeCobrancaService($this->apiClient);

        $cobrancaId = $dados['cobrancaId'];
        $documentoId = $dados['documentoId'];

        // Agora exclui o documento
        $response = $service->excluirDocumentoDeCobranca($cobrancaId, $documentoId);

      

        $this->assertIsArray($response);
    }
}
