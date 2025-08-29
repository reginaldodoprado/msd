<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\InformacoesFiscaisService;
use Tests\TestCase;

class InformacoesFiscaisServiceTest extends TestCase
{
    protected $apiClient;
    protected $informacoesFiscaisService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->informacoesFiscaisService = new InformacoesFiscaisService($this->apiClient);
    }

      /** @test */
      public function listar_configs_municipais()
      {
          $response = $this->informacoesFiscaisService->listarConfigsMunicipais();
  
          dump('RESPOSTA LISTAR CONFIGS MUNICIPAIS:', $response);
  
          $this->assertIsArray($response);
          $this->assertArrayHasKey('authenticationType', $response);
          $this->assertArrayHasKey('supportsCancellation', $response);
          $this->assertArrayHasKey('usesSpecialTaxRegimes', $response);
          $this->assertArrayHasKey('specialTaxRegimesList', $response);
      }
  

    /** @test */
    public function recuperar_informacoes_fiscais()
    {
        $response = $this->informacoesFiscaisService->recuperarInformacoesFiscais();

        

        $this->assertIsArray($response);
        // A API pode retornar array vazio se não houver informações fiscais configuradas
        $this->assertIsArray($response);
    }

  
  
    /** @test */
    public function listar_servicos_municipais()
    {
        $response = $this->informacoesFiscaisService->listarServicosMunicipais();

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function listar_codigos_nbs()
    {
        $response = $this->informacoesFiscaisService->listarCodigosNbs();

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

  
}
