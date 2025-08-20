<?php

namespace Ds\AssasIntegration\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Services\ApiClientService;

class TesteAssasController extends Controller
{
    protected $cobrancaService;
    protected $apiClient;

    public function __construct(CobrancaService $cobrancaService, ApiClientService $apiClient)
    {
        $this->cobrancaService = $cobrancaService;
        $this->apiClient = $apiClient;
    }

    /**
     * Mostra a view de teste
     */
    public function index()
    {
        return view('assas-integration::teste');
    }

    /**
     * Processa o teste de pagamento
     */
    public function testarPagamento(Request $request)
    {
        $request->validate([
            'customer' => 'required|string',
            'value' => 'required|numeric|min:0.01',
            'billingType' => 'required|in:CREDIT_CARD,PIX,BOLETO',
            'dueDate' => 'required|date',
            // Campos específicos para cartão de crédito
            'holderName' => 'required_if:billingType,CREDIT_CARD|string',
            'cardNumber' => 'required_if:billingType,CREDIT_CARD|string',
            'expiryMonth' => 'required_if:billingType,CREDIT_CARD|string|size:2',
            'expiryYear' => 'required_if:billingType,CREDIT_CARD|string|size:4',
            'ccv' => 'required_if:billingType,CREDIT_CARD|string|size:3',
            // Dados do titular
            'customerName' => 'required_if:billingType,CREDIT_CARD|string',
            'customerEmail' => 'required_if:billingType,CREDIT_CARD|email',
            'customerCpf' => 'required_if:billingType,CREDIT_CARD|string',
            'customerPhone' => 'required_if:billingType,CREDIT_CARD|string',
            'customerMobile' => 'required_if:billingType,CREDIT_CARD|string',
            'customerPostalCode' => 'required_if:billingType,CREDIT_CARD|string',
            'customerAddressNumber' => 'required_if:billingType,CREDIT_CARD|string',
            'customerAddressComplement' => 'nullable|string'
        ]);

        try {
            $dados = $request->all();
            
            // Adicionar configurações padrão
            $dados['currency'] = 'BRL';
            $dados['description'] = 'Teste via View - ' . date('Y-m-d H:i:s');
            
            // Se for cartão de crédito, estruturar os dados conforme API do Asaas
            if ($dados['billingType'] === 'CREDIT_CARD') {
                $dados['creditCard'] = [
                    'holderName' => $dados['holderName'],
                    'number' => $dados['cardNumber'],
                    'expiryMonth' => $dados['expiryMonth'],
                    'expiryYear' => $dados['expiryYear'],
                    'ccv' => $dados['ccv']
                ];
                
                $dados['creditCardHolderInfo'] = [
                    'name' => $dados['customerName'],
                    'email' => $dados['customerEmail'],
                    'cpfCnpj' => $dados['customerCpf'],
                    'postalCode' => $dados['customerPostalCode'],
                    'addressNumber' => $dados['customerAddressNumber'],
                    'addressComplement' => $dados['customerAddressComplement'] ?? null,
                    'phone' => $dados['customerPhone'],
                    'mobilePhone' => $dados['customerMobile']
                ];
                
                // Remover campos individuais para evitar duplicação
                unset($dados['holderName'], $dados['cardNumber'], $dados['expiryMonth'], 
                      $dados['expiryYear'], $dados['ccv'], $dados['customerName'], 
                      $dados['customerEmail'], $dados['customerCpf'], $dados['customerPhone'], 
                      $dados['customerMobile'], $dados['customerPostalCode'], 
                      $dados['customerAddressNumber'], $dados['customerAddressComplement']);
            }
            
            $resultado = $this->cobrancaService->criarCobrancaComCartaoDeCredito($dados);
            
            return response()->json([
                'success' => true,
                'message' => 'Pagamento criado com sucesso!',
                'data' => $resultado
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Testa a conexão com a API
     */
    public function testarConexao()
    {
        try {
            // Testar listagem de pagamentos
            $resultado = $this->apiClient->get("payments");
            
            return response()->json([
                'success' => true,
                'message' => 'Conexão com API funcionando!',
                'data' => $resultado
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro na conexão: ' . $e->getMessage()
            ], 500);
        }
    }
}
