<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\LinkDePagamentoService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço LinkDePagamentoService 
// php artisan test tests/Integration/LinkDePagamentoServiceTest.php

class LinkDePagamentoServiceTest extends TestCase
{
    protected $apiClient;
    protected $linkId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
    }

    /** @test */
    public function criar_link_de_pagamento()
    {
        $service = new LinkDePagamentoService($this->apiClient);

        $dados = [
            'name' => 'Link de Teste',
            'value' => 99.90,
            'billingType' => 'BOLETO',
            'chargeType' => 'DETACHED', // Campo obrigatório que estava faltando!
            'dueDateLimitDays' => 3,
            'notificationEnabled' => true,
            'description' => 'Teste de link de pagamento'
        ];

        $response = $service->criarLinkDePagamento($dados);

        dump('RESPOSTA CRIAR LINK DE PAGAMENTO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('value', $response);
        $this->assertEquals('Link de Teste', $response['name']);

        // Armazena o linkId para uso nos outros testes
        $this->linkId = $response['id'];

        return $response['id'];
    }

    /** @test */
    public function listar_links_de_pagamento()
    {
        $service = new LinkDePagamentoService($this->apiClient);

        $filtros = [
            'limit' => 20,
            'offset' => 0
        ];

        $response = $service->listarLinksDePagamento($filtros);

        dump('RESPOSTA LISTAR LINKS DE PAGAMENTO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('totalCount', $response);
    }

    /**
     * @test
     * @depends criar_link_de_pagamento
     */
    public function atualizar_link_de_pagamento($linkId)
    {
        $service = new LinkDePagamentoService($this->apiClient);

        // Agora atualiza o link usando o ID já criado
        $dadosAtualizados = [
            'name' => 'Link Atualizado',
            'value' => 89.90,
            'description' => 'Descrição atualizada'
        ];

        $response = $service->atualizarLinkDePagamento($linkId, $dadosAtualizados);

        dump('RESPOSTA ATUALIZAR LINK DE PAGAMENTO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($linkId, $response['id']);
        $this->assertEquals('Link Atualizado', $response['name']);
        $this->assertEquals('89.90', $response['value']);
    }

    /**
     * @test
     * @depends criar_link_de_pagamento
     */
    public function recuperar_link_de_pagamento($linkId)
    {
        $service = new LinkDePagamentoService($this->apiClient);

        // Agora recupera o link usando o ID já criado
        $response = $service->recuperarLinkDePagamento($linkId);

        dump('RESPOSTA RECUPERAR LINK DE PAGAMENTO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($linkId, $response['id']);
    }

    /**
     * @test
     * @depends criar_link_de_pagamento
     */
    public function remover_link_de_pagamento($linkId)
    {
        $service = new LinkDePagamentoService($this->apiClient);

        // Agora remove o link usando o ID já criado
        $response = $service->removerLinkDePagamento($linkId);

        dump('RESPOSTA REMOVER LINK DE PAGAMENTO:', $response);

        $this->assertIsArray($response);
    }

    /**
     * @test
     * @depends criar_link_de_pagamento
     */
    public function restaurar_link_de_pagamento($linkId)
    {
        $service = new LinkDePagamentoService($this->apiClient);

        // Remove o link
        $service->removerLinkDePagamento($linkId);

        // Agora restaura o link usando o ID já criado
        $response = $service->restaurarLinkDePagamento($linkId);

        dump('RESPOSTA RESTAURAR LINK DE PAGAMENTO:', $response);

        $this->assertIsArray($response);
    }

    /**
     * @test
     * @depends criar_link_de_pagamento
     */
    public function adicionar_imagem_ao_link_de_pagamento($linkId)
    {
        $service = new LinkDePagamentoService($this->apiClient);

        // Cria um arquivo temporário com extensão .jpg para teste
        $tempFile = tempnam(sys_get_temp_dir(), 'test_image_') . '.jpg';
        file_put_contents($tempFile, 'fake image content for testing');

        // Cria um CURLFile para simular upload real
        $curlFile = new \CURLFile($tempFile, 'image/jpeg', 'test_image.jpg');

        // Agora adiciona uma imagem usando o link já criado
        $dadosImagem = [
            'image' => $curlFile,
            'main' => true
        ];

        $response = $service->adicionarImagemAoLinkDePagamento($linkId, $dadosImagem);

        dump('RESPOSTA ADICIONAR IMAGEM:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);

        // Limpa o arquivo temporário
        unlink($tempFile);

        // Retorna tanto o linkId quanto o imagemId para os testes dependentes
        return [
            'linkId' => $linkId,
            'imagemId' => $response['id']
        ];
    }

    /**
     * @test
     * @depends criar_link_de_pagamento
     */
    public function listar_imagens_de_um_link_de_pagamento($linkId)
    {
        $service = new LinkDePagamentoService($this->apiClient);

        $response = $service->listarImagensDeUmLinkDePagamento($linkId);

        dump('RESPOSTA LISTAR IMAGENS:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
    }

    /**
     * @test
     * @depends adicionar_imagem_ao_link_de_pagamento
     */
    public function recuperar_imagem_de_um_link_de_pagamento($dados)
    {
        $service = new LinkDePagamentoService($this->apiClient);

        // Extrai os IDs do array retornado pelo teste anterior
        $linkId = $dados['linkId'];
        $imagemId = $dados['imagemId'];

        // Recupera a imagem usando os IDs extraídos
        $response = $service->recuperarImagemDeUmLinkDePagamento($linkId, $imagemId);

        dump('RESPOSTA RECUPERAR IMAGEM:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($imagemId, $response['id']);
    }

    /**
     * @test
     * @depends adicionar_imagem_ao_link_de_pagamento
     */
    public function remover_imagem_de_um_link_de_pagamento($dados)
    {
        $service = new LinkDePagamentoService($this->apiClient);

        // Extrai os IDs do array retornado pelo teste anterior
        $linkId = $dados['linkId'];
        $imagemId = $dados['imagemId'];

        // Remove a imagem usando os IDs extraídos
        $response = $service->removerImagemDeUmLinkDePagamento($linkId, $imagemId);

        dump('RESPOSTA REMOVER IMAGEM:', $response);

        $this->assertIsArray($response);
    }

    /**
     * @test
     * @depends adicionar_imagem_ao_link_de_pagamento
     */
    public function definir_imagem_principal_de_um_link_de_pagamento($dados)
    {
        $service = new LinkDePagamentoService($this->apiClient);

        // Extrai os IDs do array retornado pelo teste anterior
        $linkId = $dados['linkId'];
        $imagemId = $dados['imagemId'];

        // Define como imagem principal usando os IDs extraídos
        $response = $service->definirImagemPrincipalDeUmLinkDePagamento($linkId, $imagemId);

        dump('RESPOSTA DEFINIR IMAGEM PRINCIPAL:', $response);

        $this->assertIsArray($response);
    }
}
