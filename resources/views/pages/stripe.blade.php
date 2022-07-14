@extends('layouts.main_layout')
@section('title')
    stripe Page
@endsection
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<div class="container book-container  text-center d-flex justify-content-center">

    <div class="p-5">
        <p class="text-stripe"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto autem beatae
            fugit
            inventore molestias mollitia nam natus nemo, nihil officia praesentium quasi, ratione reprehenderit
            sapiente
            sit temporibus totam vel veritatis? </p> <br>
        <p class="text-stripe"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto autem beatae
            fugit
            inventore molestias mollitia nam natus nemo, nihil officia praesentium quasi, ratione reprehenderit
            sapiente
            sit temporibus totam vel veritatis? </p> <br>
        <p class="text-stripe"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto autem beatae
            fugit
            inventore molestias mollitia nam natus nemo, nihil officia praesentium quasi, ratione reprehenderit
            sapiente
            sit temporibus totam vel veritatis? </p>
    </div>

    <div class="col-md-6 ">
        <div class="panel panel-default credit-card-box">
            <div class="panel-heading display-table">
                <div class="row display-tr">
                    <h3 class="panel-title  mt-4">Payment Details</h3>
                </div>
            </div>
            <div class="panel-body">
                @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                @endif
                <form
                    role="form"
                    action="{{ route('stripePost',[$book->id]) }}"
                    method="post"
                    class="require-validation"
                    data-cc-on-file="false"
                    data-stripe-publishable-key="{{env('STRIPE_KEY')}}"
                    id="payment-form">
                    @csrf

                    <div class='col-xs-6 form-group required'>
                        <label class='control-label'>Name on Card</label> <input
                            class='form-control' type='text'>
                    </div>


                    <div class='col-xs-12 form-group required'>
                        <label class='control-label'>Card Number</label> <input
                            autocomplete='off' class='form-control card-number'
                            maxlength="16"
                            type='text'>
                    </div>

                    <div class='form-row row'>
                        <div class='col-xs-6 col-md-4 form-group cvc required'>
                            <label class='control-label'>CVC</label>
                            <input autocomplete='off'
                                   class='form-control card-cvc' placeholder='ex. 311' size='3'
                                   maxlength="3"
                                   type='text'>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Month</label> <input
                                class='form-control card-expiry-month' placeholder='MM' size='2'
                                maxlength="2"
                                type='text'>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Year</label> <input
                                class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                type='text' maxlength="4">
                        </div>
                    </div>
                    <div class="row p-5">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now
                                (${{$book->price}})
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>


</body>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    $(function () {
        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function (e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(','),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('hide');
            $('.has-error').removeClass('has-error');
            $inputs.each(function (i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);

            }
        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                console.log(response.error)
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* token contains id, last4, and card type */
                // alert('hello')

                var token = response['id'];
                // if (token){
                //     async function req(){
                //         let response = await fetch( )
                //     }
                // }
                // console.log(response)
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();

            }
        }
    });
</script>
</html>
