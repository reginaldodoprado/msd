<?php

namespace Ds\AssasIntegration\PaymentMethods;

use Webkul\Payment\Payment\Payment;
use Illuminate\Support\Facades\Storage;

class BoletoPaymentMethod extends Payment
{
    protected $code = 'asaas_boleto';

    public function getRedirectUrl()
    {
        return route('shop.checkout.success');
    }

    public function getImage()
    {
        $url = $this->getConfigData('image');

        return $url ? Storage::url($url) : bagisto_asset('images/boleto.png', 'shop');
    }
}
