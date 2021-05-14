<?php

namespace Worker\Cashier\Interfaces;

use Worker\Cashier\SubscriptionParam;
use Worker\Cashier\Models\Subscription;

interface PaymentGatewayInterface
{
    public function create($customer, $plan);
    public function sync($subscription);
    public function validate();
    public function isSupportRecurring();
    public function getChangePlanUrl($subscription, $plan_id, $returnUrl='/');
    public function getRenewUrl($subscription, $returnUrl='/');
    public function getCheckoutUrl($subscription, $returnUrl='/');
}