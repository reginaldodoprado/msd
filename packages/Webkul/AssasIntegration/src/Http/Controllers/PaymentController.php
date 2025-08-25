<?php

namespace Ds\AssasIntegration\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Webkul\Checkout\Facades\Cart;

use Ds\AssasIntegration\Services\AsaasService;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Services\ClienteService;

class PaymentController extends Controller
{
    protected $asaasService;
    protected $cobrancaService;
    protected $clienteService;

    public function __construct(
        AsaasService $asaasService,
        CobrancaService $cobrancaService,
        ClienteService $clienteService
    ) {
        $this->asaasService = $asaasService;
        $this->cobrancaService = $cobrancaService;
        $this->clienteService = $clienteService;
    }

    /**
     * Processar pagamento PIX
     */
    public function processPix()
    {
        $cart = Cart::getCart();
        
        if (!$cart) {
            return redirect()->back()->with('error', 'Carrinho não encontrado');
        }

        try {
           
            
            // 1. Buscar ou criar cliente no Asaas
            $cliente = $this->buscarOuCriarCliente($cart);
            
            // 2. Criar checkout no Asaas
            $checkout = $this->criarCheckoutPix($cart, $cliente);

            if (isset($checkout['errors'])) {
                return redirect()->back()->with('error', 'Erro ao criar checkout: ' . $checkout['errors'][0]['description']);
            }

            $redirectUrl = $checkout['link'] ?? $checkout['checkoutUrl'] ?? $checkout['url'] ?? null;
            
            if (!$redirectUrl) {
                return redirect()->back()->with('error', 'URL do checkout não encontrada na resposta do Asaas');
            }

            // 4. Redirecionar para Asaas
            return redirect($redirectUrl);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao processar pagamento: ' . $e->getMessage());
        }
    }

    /**
     * Processar pagamento Cartão de Crédito
     */
    public function processCartao()
    {
        $cart = Cart::getCart();
        
        if (!$cart) {
            return redirect()->back()->with('error', 'Carrinho não encontrado');
        }

        try {
         
            
            // 1. Buscar ou criar cliente no Asaas
            $cliente = $this->buscarOuCriarCliente($cart);
            
            // 2. Criar checkout no Asaas
            $checkout = $this->criarCheckoutCartao($cart, $cliente);

            if (isset($checkout['errors'])) {
                return redirect()->back()->with('error', 'Erro ao criar checkout: ' . $checkout['errors'][0]['description']);
            }

            $redirectUrl = $checkout['link'] ?? $checkout['checkoutUrl'] ?? $checkout['url'] ?? null;
            
            if (!$redirectUrl) {
                return redirect()->back()->with('error', 'URL do checkout não encontrada na resposta do Asaas');
            }

            // 4. Redirecionar para Asaas
            return redirect($redirectUrl);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao processar pagamento: ' . $e->getMessage());
        }
    }

    public function processBoleto()
    {
        // Verificar se está logado
        if (!auth()->guard('customer')->check()) {
            return redirect()->route('shop.customer.session.index')->with('error', 'Você precisa estar logado para finalizar a compra.');
        }

        try {
            $cart = Cart::getCart();
            
            // Verificar se o cart tem customer_id
            if (!$cart->customer_id) {
                return redirect()->back()->with('error', 'Carrinho inválido. Faça login novamente.');
            }
            
            // Buscar ou criar cliente no Asaas
            $cliente = $this->buscarOuCriarCliente($cart);
            
            // Criar cobrança Boleto no Asaas
            $cobranca = $this->criarCobrancaBoleto($cart, $cliente);
            
            if (isset($cobranca['errors'])) {
                return redirect()->back()->with('error', 'Erro ao criar boleto: ' . $cobranca['errors'][0]['description']);
            }
            
            // Redirecionar diretamente para a URL do boleto
            $boletoUrl =  $cobranca['invoiceUrl'] ?? $cobranca['bankSlipUrl'];   
            
          
            
            // Redirecionar diretamente para o boleto
            return redirect($boletoUrl);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao processar pagamento: ' . $e->getMessage());
        }
    }



    /**
     * Webhook do Asaas para receber notificações de pagamento
     */
    public function webhook(Request $request)
    {
        Log::info('Webhook Asaas recebido:', $request->all());

        try {
            $event = $request->input('event');
            $checkoutId = $request->input('checkout.id');

            // Verificar se é evento de checkout pago
            if ($event === 'CHECKOUT_PAID' && $checkoutId) {
                // Buscar pedido pelo checkout_id
                $order = \Webkul\Sales\Models\Order::whereHas('payment', function($query) use ($checkoutId) {
                    $query->whereJsonContains('additional->checkout_id', $checkoutId);
                })->first();

                if ($order) {
                    // Atualizar status do pedido para pago
                    $order->update(['status' => 'processing']);
                    
                    Log::info('Status do pedido atualizado para pago:', [
                        'order_id' => $order->id,
                        'checkout_id' => $checkoutId
                    ]);
                } else {
                    Log::warning('Pedido não encontrado para checkout_id:', ['checkout_id' => $checkoutId]);
                }
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar status do pedido:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Erro interno'], 500);
        }
    }

    /**
     * Sucesso do pagamento PIX/Cartão (retorno do Asaas)
     */
    public function success()
    {
 

        $cart = Cart::getCart();
        
        if (!$cart) {
            return redirect()->route('shop.checkout.cart.index')->with('error', 'Carrinho não encontrado');
        }

        try {
            // 1. Criar pedido usando OrderRepository
            $orderData = (new \Webkul\Sales\Transformers\OrderResource($cart))->jsonSerialize();
            $order = app(\Webkul\Sales\Repositories\OrderRepository::class)->create($orderData);
            
            // 2. Salvar checkout_id no pedido se existir na sessão
            $checkoutId = session('checkout_id');
            if ($checkoutId && $order->payment) {
                $order->payment->update([
                    'additional' => array_merge(
                        $order->payment->additional ?? [], 
                        ['checkout_id' => $checkoutId]
                    )
                ]);
            }
            
            // 3. Desativar carrinho
            Cart::deActivateCart();
            
            // 4. Flash order_id para a página de sucesso
            session()->flash('order_id', $order->id);
            
            // 5. Limpar checkout_id da sessão
            session()->forget('checkout_id');
            
            // 6. Redirecionar para página de sucesso
            return redirect()->route('shop.checkout.onepage.success');
            
        } catch (\Exception $e) {
            Log::error('Erro ao criar pedido no sucesso:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('shop.checkout.cart.index')->with('error', 'Erro ao finalizar pedido: ' . $e->getMessage());
        }
    }



   

    /**
     * Buscar ou criar cliente no Asaas
     */
    private function buscarOuCriarCliente($cart)
    {
        $customer = auth()->guard('customer')->user();
        $billingAddress = $cart->billing_address;

        $cpfCnpj = preg_replace('/[^0-9]/', '', $cart->billing_address->cpf_cnpj ?? 'CPF não encontrado');
        
        // Formatar telefone para o formato esperado pelo Asaas (apenas números)
        $phoneNumber = preg_replace('/[^0-9]/', '', $billingAddress->phone ?? $customer->phone ?? '');

        $dadosCliente = [
            'name' => substr($cart->billing_address->first_name . ' ' . $cart->billing_address->last_name, 0, 30),
            'email' => $cart->billing_address->email,
            'cpfCnpj' => $cpfCnpj,
            'phoneNumber' => $phoneNumber,
        ];

        // Buscar cliente existente
        $clienteExistente = $this->clienteService->listarClientes([
            'cpfCnpj' => $cpfCnpj
        ]);
        
        if (!empty($clienteExistente['data'])) {
            return $clienteExistente['data'][0];
        }

        // Criar novo cliente
        return $this->clienteService->criarCliente($dadosCliente);
    }






   

    /**
     * Criar checkout PIX
     */
    private function criarCheckoutPix($cart, $cliente)
    {
        $dados = [
            'billingTypes' => ['PIX'],
            'chargeTypes' => ['DETACHED'],
            'minutesToExpire' => 60,
            'callback' => [
                'cancelUrl' => route('shop.checkout.onepage.index'),
                'expiredUrl' => route('shop.checkout.onepage.index'),
                'successUrl' => route('assas.success')
            ],
            'items' => $this->prepararItensCarrinho($cart),
            'customerData' => $this->prepararDadosCliente($cart, $cliente)
        ];

     
        
        $response = $this->asaasService->checkout()->criarCheckout($dados);
        
       
        if (isset($response['errors'])) {
            Log::error('Checkout não foi criado com sucesso:', $response);
            return $response;
        }

        // Salvar checkout_id na sessão para usar no sucesso
        if (isset($response['id'])) {
            session(['checkout_id' => $response['id']]);
        }
        
        return $response;
    }

    /**
     * Criar checkout Cartão de Crédito
     */
    private function criarCheckoutCartao($cart, $cliente)
    {
        $dados = [
            'billingTypes' => ['CREDIT_CARD'],
            'chargeTypes' => ['DETACHED', 'INSTALLMENT'],
            'minutesToExpire' => 60,
            'installment' => [
                'maxInstallmentCount' => 12
            ],
            'callback' => [
                'cancelUrl' => route('shop.checkout.onepage.index'),
                'expiredUrl' => route('shop.checkout.onepage.index'),
                'successUrl' => route('assas.success')
            ],
            'items' => $this->prepararItensCarrinho($cart),
            'customerData' => $this->prepararDadosCliente($cart, $cliente)
        ];

        $response = $this->asaasService->checkout()->criarCheckout($dados);
        
        if (isset($response['errors'])) {
            Log::error('Checkout não foi criado com sucesso:', $response);
            return $response;
        }

        // Salvar checkout_id na sessão para usar no sucesso
        if (isset($response['id'])) {
            session(['checkout_id' => $response['id']]);
        }
       
        return $response;
    }

    /**
     * Criar cobrança Boleto no Asaas
     */
    private function criarCobrancaBoleto($cart, $cliente)
    {
        return $this->cobrancaService->criarNovaCobranca([
            'customer' => $cliente['id'],
            'billingType' => 'BOLETO',
            'value' => $cart->grand_total,
            'dueDate' => now()->addDays(3)->format('Y-m-d'),
            'description' => 'Pedido #' . $cart->id,
            'externalReference' => $cart->id,
            'notificationDisabled' => false,
            'postalCode' => $cart->billing_address->postcode,
            'addressNumber' => $cart->billing_address->address2 ?? 'S/N',
        ]);
    }



    /**
     * Preparar itens do carrinho para o checkout
     */
    private function prepararItensCarrinho($cart)
    {
        $itens = [];
        
        foreach ($cart->items as $item) {
            // Buscar a imagem do produto
            $imageBase64 = '';
            
            if ($item->product && $item->product->images && $item->product->images->first()) {
                $imagePath = $item->product->images->first()->path;
                
                // Tentar diferentes caminhos para a imagem
                $possiblePaths = [
                    public_path($imagePath), // Caminho original
                    public_path('storage/' . $imagePath), // Caminho com storage
                    storage_path('app/public/' . $imagePath), // Caminho do storage
                ];
                
                $imageData = null;
                $usedPath = null;
                
                foreach ($possiblePaths as $path) {
                    if (file_exists($path)) {
                        $imageData = file_get_contents($path);
                        $usedPath = $path;
                        break;
                    }
                }
                
                if ($imageData) {
                    // Converter WebP para JPG se necessário
                    $imageInfo = getimagesizefromstring($imageData);
                    $mimeType = $imageInfo['mime'] ?? '';
                    
                    if ($mimeType === 'image/webp') {
                        // Converter WebP para JPG
                        $image = imagecreatefromstring($imageData);
                        if ($image) {
                            // Criar buffer de saída para JPG
                            ob_start();
                            imagejpeg($image, null, 90); // Qualidade 90%
                            $jpgData = ob_get_contents();
                            ob_end_clean();
                            
                            // Liberar memória
                            imagedestroy($image);
                            
                            // Usar JPG em vez de WebP
                            $imageData = $jpgData;
                        }
                    }
                    
                    $imageBase64 = base64_encode($imageData);
                } else {
                    $imageBase64 = '';
                }
            }
            
            $itens[] = [
                'externalReference' => $item->product_id ?? $item->id, // ID único do produto
                'name' => substr($item->name ?? 'Produto', 0, 30), // Limitar a 30 caracteres
                'description' => substr($item->description ?? $item->name ?? 'Produto', 0, 150), // Limitar a 150 caracteres
                'imageBase64' => $imageBase64, // Imagem em Base64
                'quantity' => $item->quantity ?? 1,
                'value' => $item->price ?? $item->total ?? 0,
            ];
        }

        // Adicionar frete como item separado se existir
        if ($cart->shipping_amount > 0) {
            $itens[] = [
                'externalReference' => 'frete',
                'name' => 'Frete',
                'description' => 'Custo de envio',
                'imageBase64' => '',
                'quantity' => 1,
                'value' => $cart->shipping_amount,
            ];
        }

        return $itens;
    }

    /**
     * Preparar dados do cliente para o checkout
     */
    private function prepararDadosCliente($cart, $cliente)
    {
        $customer = auth()->guard('customer')->user();
        $billingAddress = $cart->billing_address;

        $cpfCnpj = preg_replace('/[^0-9]/', '', $cart->billing_address->cpf_cnpj ?? 'CPF não encontrado');
        
        // Formatar telefone para o formato esperado pelo Asaas (apenas números)
        $phoneNumber = preg_replace('/[^0-9]/', '', $billingAddress->phone ?? $customer->phone ?? '');
        
    
        
        return [
            'name' => substr($cart->billing_address->first_name . ' ' . $cart->billing_address->last_name, 0, 30), // Limitar a 30 caracteres
            'cpfCnpj' => $cpfCnpj, // CPF sem formatação do carrinho
            'email' => $cart->billing_address->email,
            'phone' => $phoneNumber, // Telefone validado para o Asaas
            'address' => $cart->billing_address->address ?? 'Endereço',
            'addressNumber' => $cart->billing_address->addressNumber ?? 'S/N',
            'province' => $cart->billing_address->city ?? 'Centro',
            'postalCode' => $cart->billing_address->postcode,
        ];
    
    }
}
