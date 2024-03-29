<html lang="en">
    <head>
        <title>{{ trans('cashier::messages.direct.renew_subscription') }}</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <link rel="stylesheet" href="{{ \Worker\Cashier\Cashier::public_url('/vendor/ema-cashier/css/main.css') }}">
    </head>
    
    <body>
        <div class="row mt-40">
            <div class="col-md-2"></div>
            <div class="col-md-4 mt-40 pd-60">
                <label class="text-semibold text-muted mb-20 mt-0">
                    <strong>
                        {{ trans('cashier::messages.direct.renew_subscription') }}
                    </strong>
                </label>
                <img width="100%" src="{{ \Worker\Cashier\Cashier::public_url('/vendor/ema-cashier/image/direct.png') }}" />
            </div>
            <div class="col-md-4 mt-40 pd-60">
                <label>{{ $subscription->plan->getBillableName() }}</label>  
                <h2 class="mb-40">{{ $subscription->plan->getBillableFormattedPrice() }}</h2>
                    
                <p>{!! trans('cashier::messages.direct.renew_plan.intro', [
                    'plan' => $subscription->plan->getBillableName(),
                ]) !!}</p>
                    
                <ul class="dotted-list topborder section mb-4">
                    <li>
                        <div class="unit size1of2">
                            {{ trans('cashier::messages.direct.next_period_day') }}
                        </div>
                        <div class="lastUnit size1of2">
                            <mc:flag>{!! $subscription->nextPeriod() !!}</mc:flag>
                        </div>
                    </li>
                    <li>
                        <div class="unit size1of2">
                            {{ trans('cashier::messages.direct.plan') }}
                        </div>
                        <div class="lastUnit size1of2">
                            <mc:flag>{{ $subscription->plan->getBillableName() }}</mc:flag>
                        </div>
                    </li>
                    <li>
                        <div class="unit size1of2">
                            {{ trans('cashier::messages.direct.amount') }}
                        </div>
                        <div class="lastUnit size1of2">
                            <mc:flag>{{ $subscription->plan->getBillableFormattedPrice() }}</mc:flag>
                        </div>
                    </li>
                </ul>
                
                <form method="POST" action="{{ \Worker\Cashier\Cashier::lr_action('\Worker\Cashier\Controllers\DirectController@renew', ['subscription_id' => $subscription->uid]) }}">
                    {{ csrf_field() }}
                    
                    <button
                        class="btn btn-primary mr-10 mr-2"
                    >{{ trans('cashier::messages.direct.renew_proceed') }}</button>
                        
                    <a
                    href="{{ $return_url }}"
                        class="btn btn-secondary mr-10"
                    >{{ trans('cashier::messages.direct.return_back') }}</a>
                </form>
                    
            </div>
            <div class="col-md-2"></div>
        </div>
        <br />
        <br />
        <br />
    </body>
</html>