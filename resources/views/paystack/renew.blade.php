<html lang="en">
    <head>
        <title>{{ trans('cashier::messages.paystack.renew') }}</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <link rel="stylesheet" href="{{ \Worker\Cashier\Cashier::public_url('/vendor/ema-cashier/css/main.css') }}">
    </head>
    
    <body>
        <div class="main-container row mt-40">
            <div class="col-md-2"></div>
            <div class="col-md-4 mt-40 pd-60">
                <label class="text-semibold text-muted mb-20 mt-0">
                    <strong>
                        {{ trans('cashier::messages.paystack.checkout_with_paystack') }}
                    </strong>
                </label>
                <img class="rounded" width="100%" src="{{ \Worker\Cashier\Cashier::public_url('/vendor/ema-cashier/image/paystack.svg') }}" />
            </div>
            <div class="col-md-4 mt-40 pd-60">                
                <label>{{ $subscription->plan->getBillableName() }}</label>  
                <h2 class="mb-40">{{ $subscription->plan->getBillableFormattedPrice() }}</h2>
                
                
                <p>{!! trans('cashier::messages.paystack.renew.click_bellow_to_pay', [
                    'plan' => $subscription->plan->getBillableName(),
                    'price' => $subscription->plan->getBillableFormattedPrice(),
                ]) !!}</p>

                <ul class="dotted-list topborder section mb-4">
                    <li>
                        <div class="unit size1of2">
                            {{ trans('cashier::messages.razorpay.plan') }}
                        </div>
                        <div class="lastUnit size1of2">
                            <mc:flag>{{ $subscription->plan->getBillableName() }}</mc:flag>
                        </div>
                    </li>
                    <li>
                        <div class="unit size1of2">
                            {{ trans('cashier::messages.razorpay.next_period_day') }}
                        </div>
                        <div class="lastUnit size1of2">
                            <mc:flag>{{ $subscription->nextPeriod() }}</mc:flag>
                        </div>
                    </li>
                    <li>
                        <div class="unit size1of2">
                            {{ trans('cashier::messages.razorpay.amount') }}
                        </div>
                        <div class="lastUnit size1of2">
                            <mc:flag>{{ $subscription->plan->getBillableFormattedPrice() }}</mc:flag>
                        </div>
                    </li>
                </ul>

                <form id="paymentForm">
                    <a href="javascript:;" class="btn btn-secondary full-width" onclick="payWithPaystack()">
                        {{ trans('cashier::messages.paystack.renew') }}
                    </a>
                </form>
                <script src="https://js.paystack.co/v1/inline.js"></script> 

                <form id="checkoutForm" method="GET" action="{{ \Worker\Cashier\Cashier::lr_action('\Worker\Cashier\Controllers\PaystackController@paymentRedirect') }}">
                    <input type="hidden" name="redirect" value="" />
                </form>
                
                <script>
                    var paymentForm = document.getElementById('paymentForm');
                    paymentForm.addEventListener('submit', payWithPaystack, false);
                    function payWithPaystack() {
                        var handler = PaystackPop.setup({
                            key: '{{ $service->public_key }}', // Replace with your public key
                            email: '{{ $subscription->user->getBillableEmail() }}',
                            amount: {{ $subscription->plan->getBillableAmount() }} * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
                            currency: '{{ $subscription->plan->getBillableCurrency() }}', // Use GHS for Ghana Cedis or USD for US Dollars
                            firstname: '',
                            lastname: '',
                            reference: ''+Math.floor((Math.random() * 1000000000) + 1), // Replace with a reference you generated
                            callback: function(response) {
                                var reference = response.reference;
                                var url = '{{ \Worker\Cashier\Cashier::lr_action('\Worker\Cashier\Controllers\PaystackController@renew', [
                                    'subscription_id' => $subscription->uid,
                                ]) }}?reference=' + reference;
                                
                                $('[name="redirect"]').val(url);
                                $('#checkoutForm').submit();
                            },
                            onClose: function() {
                                alert('Transaction was not completed, window closed.');
                            },
                        });
                        handler.openIframe();
                    }
                </script>
            </div>
            <div class="col-md-2"></div>
        </div>
        <br />
        <br />
        <br />
    </body>
</html>