<?php

namespace Ds\AssasIntegration\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Services\ApiClientService;

class AssasController extends Controller
{
    protected $cobrancaService;
    protected $apiClient;

    public function __construct(CobrancaService $cobrancaService, ApiClientService $apiClient)
    {
        $this->cobrancaService = $cobrancaService;
        $this->apiClient = $apiClient;
    }

    /**
     * Criar um pagamento com cartão de crédito
     */
    public function criarPagamento(Request $request): JsonResponse
    {
        $request->validate([
            'customer' => 'required|string',
            'value' => 'required|numeric|min:0.01',
            'dueDate' => 'required|date',
            'billingType' => 'required|in:CREDIT_CARD,BOLETO,PIX',
            'creditCard.holderName' => 'required_if:billingType,CREDIT_CARD|string',
            'creditCard.number' => 'required_if:billingType,CREDIT_CARD|string',
            'creditCard.expiryMonth' => 'required_if:billingType,CREDIT_CARD|string|size:2',
            'creditCard.expiryYear' => 'required_if:billingType,CREDIT_CARD|string|size:4',
            'creditCard.ccv' => 'required_if:billingType,CREDIT_CARD|string|min:3|max:4',
        ]);

        try {
            $dados = $request->all();
            
            // Adicionar configurações padrão se não fornecidas
            $dados['currency'] = $dados['currency'] ?? config('assas-integration.payment.currency', 'BRL');
            
            $resultado = $this->cobrancaService->criarCobrancaComCartaoDeCredito($dados);
            
            return response()->json([
                'success' => true,
                'message' => 'Pagamento criado com sucesso!',
                'data' => $resultado
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar pagamento: ' . $e->getMessage()
            ], 500);
        }
    }

   
}
