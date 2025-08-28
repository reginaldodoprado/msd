<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\ExtratoService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço ExtratoService 
// php artisan test tests/Integration/ExtratoServiceTest.php

class ExtratoServiceTest extends TestCase
{
    protected $apiClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
    }

    /** @test */
    public function recuperar_extrato()
    {
        $service = new ExtratoService($this->apiClient);

        $response = $service->recuperarExtrato();

      

        $this->assertIsArray($response);
    }
}
