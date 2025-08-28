<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\AssinaturaService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço AssinaturaService 
// php artisan test tests/Integration/AssinaturaServiceTest.php

class AssinaturaServiceTest extends TestCase
{
    protected $apiClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
    }

    /** @test */
    public function criar_assinatura()
    {
        $service = new AssinaturaService($this->apiClient);

        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 99.90,
            'nextDueDate' => '2025-12-31',
            'cycle' => 'MONTHLY',
            'description' => 'Teste de assinatura mensal'
        ];

        $response = $service->criarAssinatura($dados);

        dump('RESPOSTA CRIAR ASSINATURA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('value', $response);
        $this->assertArrayHasKey('billingType', $response);
        $this->assertEquals('99.90', $response['value']);

        return $response['id'];
    }

    /** @test */
    public function listar_assinaturas()
    {
        $service = new AssinaturaService($this->apiClient);

        $filtros = [
            'limit' => 20,
            'offset' => 0
        ];

        $response = $service->listarAssinaturas($filtros);

        dump('RESPOSTA LISTAR ASSINATURAS:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('totalCount', $response);
    }

    /** @test */
    public function criar_assinatura_com_cartao_de_credito()
    {
        $service = new AssinaturaService($this->apiClient);

        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'CREDIT_CARD',
            'value' => 149.90,
            'nextDueDate' => '2025-12-31',
            'cycle' => 'MONTHLY',
            'description' => 'Teste de assinatura com cartão',
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

        $response = $service->criarAssinaturaComCartaoDeCredito($dados);

        dump('RESPOSTA CRIAR ASSINATURA COM CARTÃO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('billingType', $response);
        $this->assertEquals('CREDIT_CARD', $response['billingType']);

        return $response['id'];
    }

    /** @test */
    public function buscar_assinatura()
    {
        $service = new AssinaturaService($this->apiClient);

        // Primeiro lista as assinaturas para pegar um ID real
        $filtros = [
            'limit' => 1,
            'offset' => 0
        ];

        $listaAssinaturas = $service->listarAssinaturas($filtros);
        
        $this->assertIsArray($listaAssinaturas);
        $this->assertArrayHasKey('data', $listaAssinaturas);
        $this->assertNotEmpty($listaAssinaturas['data']);

        // Pega o ID da primeira assinatura encontrada
        $assinaturaId = $listaAssinaturas['data'][0]['id'];

        // Agora busca os detalhes dessa assinatura
        $response = $service->buscarAssinatura($assinaturaId);

        dump('RESPOSTA BUSCAR ASSINATURA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($assinaturaId, $response['id']);
    }

    /** @test */
    public function atualizar_assinatura()
    {
        $service = new AssinaturaService($this->apiClient);

        // Primeiro cria uma assinatura para atualizar
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 79.90,
            'nextDueDate' => '2025-12-31',
            'cycle' => 'MONTHLY',
            'description' => 'Teste de atualização'
        ];

        $assinatura = $service->criarAssinatura($dados);
        $assinaturaId = $assinatura['id'];

        // Agora atualiza a assinatura
        $dadosAtualizados = [
            'description' => 'Descrição atualizada',
            'value' => 89.90
        ];

        $response = $service->atualizarAssinatura($assinaturaId, $dadosAtualizados);

        dump('RESPOSTA ATUALIZAR ASSINATURA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($assinaturaId, $response['id']);
        $this->assertEquals('Descrição atualizada', $response['description']);
        $this->assertEquals('89.90', $response['value']);
    }

    /** @test */
    public function remover_assinatura()
    {
        $service = new AssinaturaService($this->apiClient);

        // Primeiro cria uma assinatura para remover
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 59.90,
            'nextDueDate' => '2025-12-31',
            'cycle' => 'MONTHLY',
            'description' => 'Teste de remoção'
        ];

        $assinatura = $service->criarAssinatura($dados);
        $assinaturaId = $assinatura['id'];

        // Agora remove a assinatura
        $response = $service->removerAssinatura($assinaturaId);

        dump('RESPOSTA REMOVER ASSINATURA:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function atualizar_cartao_sem_efetuar_cobranca()
    {
        $service = new AssinaturaService($this->apiClient);

        // Primeiro cria uma assinatura com cartão
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'CREDIT_CARD',
            'value' => 99.90,
            'nextDueDate' => '2025-12-31',
            'cycle' => 'MONTHLY',
            'description' => 'Teste de atualização de cartão',
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

        $assinatura = $service->criarAssinatura($dados);
        $assinaturaId = $assinatura['id'];

        // Agora atualiza o cartão
        $dadosCartao = [
            'creditCard' => [
                'holderName' => 'Maria Santos',
                'number' => '5555555555554444',
                'expiryMonth' => '10',
                'expiryYear' => '2026',
                'ccv' => '321'
            ],
            'creditCardHolderInfo' => [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@teste.com',
                'cpfCnpj' => '12345678909',
                'phone' => '11987654321',
                'postalCode' => '07145100',
                'addressNumber' => '456',
                'addressComplement' => 'Casa 12',
                'mobilePhone' => '11987654321'
            ],
            'remoteIp' => '192.168.1.1'
        ];

        $response = $service->atualizarCartaoSemEfetuarCobranca($assinaturaId, $dadosCartao);

        dump('RESPOSTA ATUALIZAR CARTÃO:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function listar_cobrancas_de_uma_assinatura()
    {
        $service = new AssinaturaService($this->apiClient);

        // Primeiro cria uma assinatura
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 99.90,
            'nextDueDate' => '2025-12-31',
            'cycle' => 'MONTHLY',
            'description' => 'Teste de listar cobranças'
        ];

        $assinatura = $service->criarAssinatura($dados);
        $assinaturaId = $assinatura['id'];

        $filtros = [
            'limit' => 10,
            'offset' => 0
        ];

        $response = $service->listarCobrancasDeUmaAssinatura($assinaturaId, $filtros);

        dump('RESPOSTA LISTAR COBRANÇAS DA ASSINATURA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
    }

    /** @test */
    public function gerar_carne_de_assinatura()
    {
        $service = new AssinaturaService($this->apiClient);

        // Primeiro cria uma assinatura
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 99.90,
            'nextDueDate' => '2025-12-31',
            'cycle' => 'MONTHLY',
            'description' => 'Teste de gerar carnê'
        ];

        $assinatura = $service->criarAssinatura($dados);
        $assinaturaId = $assinatura['id'];

        // Adiciona parâmetros de mês e ano para gerar o carnê
        $filtros = [
            'month' => 12,   // Agosto (mês atual)
            'year' => 2025  // Ano atual
        ];
        
        $response = $service->gerarCarneDeAssinatura($assinaturaId, $filtros);

      

        $this->assertIsArray($response);
        
    
    }

    /** @test */
    public function criar_configuracao_para_emissao_de_nota_fiscal()
    {
        $service = new AssinaturaService($this->apiClient);

        // Primeiro cria uma assinatura
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 99.90,
            'nextDueDate' => '2025-12-31',
            'cycle' => 'MONTHLY',
            'description' => 'Teste de configuração de NF'
        ];

        $assinatura = $service->criarAssinatura($dados);
        $assinaturaId = $assinatura['id'];

        $dadosConfig = [
            'municipalServiceId' => '123456',
            'municipalServiceCode' => '0107',
            'municipalServiceName' => 'Teste de serviço',
            'updatePayment' => false,
            'receivedOnly' => true,
            'effectiveDatePeriod' => 'ON_PAYMENT_CONFIRMATION',
            'daysBeforeDueDate' => 5,
            'observations' => 'Nota fiscal para teste de integração',
            'deductions' => 0,
            'taxes' => [
                'iss' => 5.0,
                'ir' => 0.0,
                'pis' => 0.65,
                'cofins' => 3.0
            ]
        ];

        $response = $service->criarConfiguracaoParaEmissaoDeNotaFiscal($assinaturaId, $dadosConfig);

        dump('RESPOSTA CRIAR CONFIGURAÇÃO NF:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function recuperar_configuracao_para_emissao_de_nota_fiscal()
    {
        $service = new AssinaturaService($this->apiClient);

        // Primeiro cria uma assinatura
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 99.90,
            'nextDueDate' => '2025-12-31',  
            'cycle' => 'MONTHLY',
            'description' => 'Teste de recuperar configuração NF'
        ];

        $assinatura = $service->criarAssinatura($dados);
        $assinaturaId = $assinatura['id'];

        $dadosConfig = [
            'municipalServiceId' => '654321',
            'municipalServiceCode' => '0701',
            'municipalServiceName' => 'Serviço atualizado',
            'updatePayment' => true,
            'receivedOnly' => false,
            'effectiveDatePeriod' => 'ON_PAYMENT_CONFIRMATION',
            'daysBeforeDueDate' => 3,
            'observations' => 'Configuração de NF atualizada para teste',
            'deductions' => 10.0,
            'taxes' => [
                'iss' => 4.5,
                'ir' => 0.0,
                'pis' => 0.65,
                'cofins' => 3.0
            ]
        ];

        $assinatura = $service->criarConfiguracaoParaEmissaoDeNotaFiscal($assinaturaId, $dadosConfig);

       

        $response = $service->recuperarConfiguracaoParaEmissaoDeNotaFiscal($assinaturaId);

        dump('RESPOSTA RECUPERAR CONFIGURAÇÃO NF:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function remover_configuracao_para_emissao_de_nota_fiscal()
    {
        $service = new AssinaturaService($this->apiClient);

        // Primeiro cria uma assinatura
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 99.90,   
            'nextDueDate' => '2025-12-31',
            'cycle' => 'MONTHLY',
            'description' => 'Teste de remover configuração NF'
        ];

        $assinatura = $service->criarAssinatura($dados);
        $assinaturaId = $assinatura['id'];
        $dadosConfig = [
            'municipalServiceId' => '123456',
            'municipalServiceCode' => '0107',
            'municipalServiceName' => 'Teste de serviço',
            'updatePayment' => false,
            'receivedOnly' => true,
            'effectiveDatePeriod' => 'ON_PAYMENT_CONFIRMATION',
            'daysBeforeDueDate' => 5,
            'observations' => 'Nota fiscal para teste de integração',
            'deductions' => 0,
            'taxes' => [
                'iss' => 5.0,
                'ir' => 0.0,
                'pis' => 0.65,
                'cofins' => 3.0
            ]  
        ];

        $assinatura = $service->criarConfiguracaoParaEmissaoDeNotaFiscal($assinaturaId, $dadosConfig);

        $response = $service->removerConfiguracaoParaEmissaoDeNotaFiscal($assinaturaId);

        dump('RESPOSTA REMOVER CONFIGURAÇÃO NF:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function atualizar_configuracao_para_emissao_de_nota_fiscal()
    {
        $service = new AssinaturaService($this->apiClient);

        // Primeiro cria uma assinatura
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 99.90,
            'nextDueDate' => '2025-12-31',
            'cycle' => 'MONTHLY',
            'description' => 'Teste de atualizar configuração NF'
        ];

        $assinatura = $service->criarAssinatura($dados);
        $assinaturaId = $assinatura['id'];

        $dadosConfig = [
            'municipalServiceId' => '654321',
            'municipalServiceCode' => '0701',
            'municipalServiceName' => 'Serviço atualizado',
            'updatePayment' => true,
            'receivedOnly' => false,
            'effectiveDatePeriod' => 'ON_PAYMENT_CONFIRMATION',
            'daysBeforeDueDate' => 3,
            'observations' => 'Configuração de NF atualizada para teste',
            'deductions' => 10.0,
            'taxes' => [
                'iss' => 4.5,
                'ir' => 0.0,
                'pis' => 0.65,
                'cofins' => 3.0
            ]
        ];

        $response = $service->atualizarConfiguracaoParaEmissaoDeNotaFiscal($assinaturaId, $dadosConfig);

        dump('RESPOSTA ATUALIZAR CONFIGURAÇÃO NF:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function listar_notas_fiscais_de_uma_assinatura()
    {
        $service = new AssinaturaService($this->apiClient);

        // Primeiro cria uma assinatura
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 99.90,
            'nextDueDate' => '2025-12-31',
            'cycle' => 'MONTHLY',
            'description' => 'Teste de listar notas fiscais'
        ];

        $assinatura = $service->criarAssinatura($dados);
        $assinaturaId = $assinatura['id'];

        $dadosConfig = [
            'municipalServiceId' => '654321',
            'municipalServiceCode' => '0701',
            'municipalServiceName' => 'Serviço atualizado',
            'updatePayment' => true,
            'receivedOnly' => false,
            'effectiveDatePeriod' => 'ON_PAYMENT_CONFIRMATION',
            'daysBeforeDueDate' => 3,
            'observations' => 'Configuração de NF atualizada para teste',
            'deductions' => 10.0,
            'taxes' => [
                'iss' => 4.5,
                'ir' => 0.0,
                'pis' => 0.65,
                'cofins' => 3.0
            ]
        ];

        $assinatura = $service->criarConfiguracaoParaEmissaoDeNotaFiscal($assinaturaId, $dadosConfig);

        $filtros = [
            'limit' => 10,
            'offset' => 0
        ];

        $response = $service->listarNotasFiscaisDeUmaAssinatura($assinaturaId, $filtros);

        dump('RESPOSTA LISTAR NOTAS FISCAIS:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
    }
}
