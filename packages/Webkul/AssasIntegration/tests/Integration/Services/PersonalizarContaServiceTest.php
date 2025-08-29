<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\PersonalizarContaService;
use Tests\TestCase;

class PersonalizarContaServiceTest extends TestCase
{
    protected $apiClient;
    protected $personalizarContaService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->personalizarContaService = new PersonalizarContaService($this->apiClient);
    }

    /** @test */
    public function recuperar_dados_comerciais()
    {
        $response = $this->personalizarContaService->recuperarDadosComerciais();

       

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }
    

   /** @test */
   public function salvar_personalizacao_da_fatura()

   {

    $dados = [
        "logoBackgroundColor" => "#007AB4",
        "infoBackgroundColor" => "#1DA9DA",
        "fontColor" => "#FFFFFF",
        "enabled" => false
    ];
    $response = $this->personalizarContaService->salvarPersonalizacaoDaFatura($dados);
    
   

    $this->assertIsArray($response);
    $this->assertNotEmpty($response);
   }

    /** @test */
    public function recuperar_personalizacao_da_fatura()
    {
        $response = $this->personalizarContaService->recuperarPersonalizacaoDaFatura();

        

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }

    /** @test */
    public function recuperar_numero_de_conta()
    {
        $response = $this->personalizarContaService->recuperarNumeroDeConta();

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('agency', $response);
        $this->assertArrayHasKey('account', $response);
        $this->assertArrayHasKey('accountDigit', $response);
        $this->assertNotEmpty($response['agency']);
    }

    /** @test */
    public function recuperar_taxas_da_conta()
    {
        $response = $this->personalizarContaService->recuperarTaxasDaConta();

        

        $this->assertIsArray($response);
        // A API pode retornar array vazio se não houver taxas configuradas
        $this->assertIsArray($response);
    }

    /** @test */
    public function consultar_situacao_cadastral()
    {
        $response = $this->personalizarContaService->consultarSituacaoCadastral();

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('commercialInfo', $response);
        $this->assertArrayHasKey('bankAccountInfo', $response);
        $this->assertArrayHasKey('documentation', $response);
        $this->assertArrayHasKey('general', $response);
    }

    /** @test */
    public function recuperar_wallet()
    {
        $response = $this->personalizarContaService->recuperarWallet();

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

   
}
