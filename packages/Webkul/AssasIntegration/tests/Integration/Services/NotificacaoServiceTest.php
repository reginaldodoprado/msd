<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\NotificacaoService;
use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\ClienteService;

// teste individual do serviço NotificacaoService 
// php artisan test tests/Integration/NotificacaoServiceTest.php

class NotificacaoServiceTest extends TestCase
{
    protected $apiClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
    }

     /** @test */
     public function criar_cliente_para_teste()
     {
         $service = new ClienteService($this->apiClient);
 
         $dados = [
             'name' => 'teste',
             'email' => 'juan@dsaplicativos.com.br',
             'phone' => '11994152001',
             'cpfCnpj' => '24971563792',
             'postalCode' => '07145100',
             'addressNumber' => '123',
             'addressComplement' => 'Apto 1'
         ];
 
         $response = $service->criarCliente($dados);
 
      
 
         return $response['id'];
     }
  

    /**
     * @test
     * @depends criar_cliente_para_teste
     */
    public function recuperar_notificacao_de_um_cliente($clienteId)
    {
        $service = new NotificacaoService($this->apiClient);

        $response = $service->recuperarNotificacaoDeUmCliente($clienteId);

        

        $this->assertIsArray($response);

        return ['notificacaoId0' => $response['data'][0]['id'], 'notificacaoId1' => $response['data'][1]['id']];
        
    }

    /**
     * @test
     * @depends recuperar_notificacao_de_um_cliente
     */
    public function atualizar_notificacao_existente($notificacaoId) 
    {
        $notificacaoId0 = $notificacaoId['notificacaoId0'];
        
        

        $service = new NotificacaoService($this->apiClient);

        // Dados para atualizar a notificação conforme a documentação
        $dados = [
            'enabled' => true,
            'emailEnabledForProvider' => true,
            
            
        ];

       

        $response = $service->atualizarNotificacao($notificacaoId0, $dados);

       

        $this->assertIsArray($response);
    }

    /**
     * @test
     * @depends criar_cliente_para_teste
     * @depends recuperar_notificacao_de_um_cliente
     */
    public function atualizar_notificacoes_em_lote($clienteId, $notificacaoId)
    {
        $notificacaoId0 = $notificacaoId['notificacaoId0'];
        $notificacaoId1 = $notificacaoId['notificacaoId1'];

        $service = new NotificacaoService($this->apiClient);

        // Dados para atualizar em lote conforme a documentação
        $dados = [
            'customer' => $clienteId,
            'notifications' => [
                [    'id' => $notificacaoId0,
                    'enabled' => true,
                    'emailEnabledForProvider' => true
                 
                   
                ],
                [   'id' => $notificacaoId1,
                    'enabled' => true,
                    'emailEnabledForProvider' => true
                    
                    
                ]
            ]
        ];

        $response = $service->atualizarEmLote($dados);

       

        $this->assertIsArray($response);
    }
}
