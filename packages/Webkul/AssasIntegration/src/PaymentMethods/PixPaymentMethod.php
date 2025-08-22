<?php

namespace Ds\AssasIntegration\PaymentMethods;

use Webkul\Payment\Payment\Payment;
use Illuminate\Support\Facades\Storage;

/**
 * PIX Payment Method
 * 
 * Método de pagamento específico para PIX via Asaas
 */
class PixPaymentMethod extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code = 'asaas_pix';

    /**
     * Get redirect url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return route('assas.pix.process');
    }

    /**
     * Get payment method image.
     *
     * @return string
     */
    public function getImage()
    {
        $url = $this->getConfigData('image');
        
        return $url ? Storage::url($url) : bagisto_asset('images/cartao.png', 'shop');
   
    }
}
