<?php

namespace Worker\Cashier\Interfaces;

interface PaymentGatewayInterface
{
    public function supportsAutoBilling();
    public function getCheckoutUrl($invoice, $returnUrl='/');
}
