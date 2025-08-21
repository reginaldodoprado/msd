<?php

namespace Ds\AssasIntegration\PaymentMethods;

use Webkul\Payment\Payment\Payment;
use Illuminate\Support\Facades\Storage;

class PixCartaoPaymentMethod extends Payment
{
    protected $code = 'asaas_pix_cartao';

    public function getRedirectUrl()
    {
        return route('shop.checkout.success');
    }

    public function getImage()
    {
        $url = $this->getConfigData('image');

        return $url ? Storage::url($url) : bagisto_asset('images/pix-cartao.png', 'shop');
    }
}
