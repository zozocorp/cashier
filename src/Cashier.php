<?php

namespace Worker\Cashier;

use Illuminate\Support\ServiceProvider;

class Cashier
{
    /**
     * Get payment gateway.
     *
     * @var array
     */
    public static function wp_action($name, $parameters = [], $absolute = true)
    {
        if (defined('WORDPRESS_MODE')) {
            return wp_action($name, $parameters, $absolute);
        } else {
            return action($name, $parameters, $absolute);
        }
    }
    public static function lr_action($name, $parameters = [], $absolute = true)
    {
        if (defined('WORDPRESS_MODE')) {
            return lr_action($name, $parameters, $absolute);
        } else {
            return action($name, $parameters, $absolute);
        }
    }
    public static function public_url($path)
    {
        if (defined('WORDPRESS_MODE')) {
            return public_url($path);
        } else {
            return url($path);
        }
    }

    /**
     * Get payment gateway.
     *
     * @var array
     */
    public static function getPaymentGateway($meta, $fields=null)
    {
        // overide fields, for validate before save
        if (isset($fields)) {
            $meta['fields'] = $fields;
        }

        switch ($meta['name']) {
            case 'direct':
                return new \Worker\Cashier\Services\DirectPaymentGateway(
                    $meta['fields']['payment_instruction'],
                    $meta['fields']['confirmation_message']
                );
            case 'stripe':
                return new \Worker\Cashier\Services\StripePaymentGateway(
                    $meta['fields']['secret_key'],
                    $meta['fields']['publishable_key'],
                    $meta['fields']['always_ask_for_valid_card'],
                    $meta['fields']['billing_address_required']
                );
            case 'braintree':
                return new \Worker\Cashier\Services\BraintreePaymentGateway(
                    $meta['fields']['environment'],
                    $meta['fields']['merchant_id'],
                    $meta['fields']['public_key'],
                    $meta['fields']['private_key'],
                    $meta['fields']['always_ask_for_valid_card']
                );
            case 'coinpayments':
                return new \Worker\Cashier\Services\CoinpaymentsPaymentGateway(
                    $meta['fields']['merchant_id'],
                    $meta['fields']['public_key'],
                    $meta['fields']['private_key'],
                    $meta['fields']['ipn_secret'],
                    $meta['fields']['receive_currency']
                );
            case 'paypal':
                return new \Worker\Cashier\Services\PaypalPaymentGateway(
                    $meta['fields']['environment'],
                    $meta['fields']['client_id'],
                    $meta['fields']['secret']
                );
            case 'paypal_subscription':
                return new \Worker\Cashier\Services\PaypalSubscriptionPaymentGateway(
                    $meta['fields']['environment'],
                    $meta['fields']['client_id'],
                    $meta['fields']['secret']
                );
            case 'razorpay':
                return new \Worker\Cashier\Services\RazorpayPaymentGateway(
                    $meta['fields']['key_id'],
                    $meta['fields']['key_secret']
                );
            case 'paystack':
                return new \Worker\Cashier\Services\PaystackPaymentGateway(
                    $meta['fields']['public_key'],
                    $meta['fields']['secret_key']
                );
            default:
                throw new \Exception("Can not find payment service: " . $meta['name']);
        }
    }
}