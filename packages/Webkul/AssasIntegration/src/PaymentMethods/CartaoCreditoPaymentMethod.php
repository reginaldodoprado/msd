<?php

namespace Ds\AssasIntegration\PaymentMethods;

use Webkul\Payment\Payment\Payment;
use Illuminate\Support\Facades\Storage;

class CartaoCreditoPaymentMethod extends Payment
{
    /**
     * Payment method code.
     *
     * @var string
     */
    protected $code = 'asaas_cartao';

    /**
     * Get redirect url.
     *
     * @var string
     */
    public function getRedirectUrl()
    {
        return route('assas.cartao.process');
    }

    /**
     * Get payment method image.
     *
     * @var string
     */
    public function getImage()
    {
        $url = $this->getConfigData('image');
        
        return $url ? Storage::url($url) : bagisto_asset('images/cartao.png', 'shop');
    }
}
