<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\ChargeBackService;
use Tests\TestCase;

class ChargeBackServiceTest extends TestCase
{
    protected $apiClient;
    protected $chargeBackService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->chargeBackService = new ChargeBackService($this->apiClient);
    }

    /** @test */
    public function listar_chargebacks()
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0
        ];

        $response = $this->chargeBackService->listarChargebacks($filtros);

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

   
}
