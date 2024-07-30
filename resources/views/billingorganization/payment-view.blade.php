@extends('master')

@section('javascripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
// Create an instance of the Stripe object
// Set your publishable API key
var stripe = Stripe("{{ env('STRIPE_KEY') }}");


// Create an instance of elements
var elements = stripe.elements();

var style = {
    base: {
        fontWeight: 400,
        fontFamily: '"DM Sans", Roboto, Open Sans, Segoe UI, sans-serif',
        fontSize: '16px',
        lineHeight: '1.4',
        color: '#1b1642',
        padding: '.75rem 1.25rem',
        '::placeholder': {
            color: '#ccc',
        },
    },
    invalid: {
        color: '#dc3545',
    }
};

var cardElement = elements.create('cardNumber', {
    style: style
});
cardElement.mount('#card_number');

var exp = elements.create('cardExpiry', {
    'style': style
});
exp.mount('#card_expiry');

var cvc = elements.create('cardCvc', {
    'style': style
});

cvc.mount('#card_cvc');

// Validate input of the card elements
var resultContainer = document.getElementById('paymentResponse');
cardElement.addEventListener('change', function(event) {
    if (event.error) {
        resultContainer.innerHTML = '<p>' + event.error.message + '</p>';
    } else {
        resultContainer.innerHTML = '';
    }
});

// Get payment form element
var form = document.getElementById('payment-form');

// Create a token when the form is submitted.
form.addEventListener('submit', function(e) {
    e.preventDefault();
    createToken();
});

// Create single-use token to charge the user
function createToken() {
    stripe.createToken(cardElement).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error
            resultContainer.innerHTML = '<p>' + result.error.message + '</p>';
        } else {
            // Send the token to your server
            stripeTokenHandler(result.token);
        }
    });
}

// Callback to handle the response from stripe
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}

$('.pay-via-stripe-btn').on('click', function() {
    var payButton = $(this);
    var name = $('#name').val();
    var email = $('#email').val();
    var re_amount = $('#re_amount').val();

    if (name == '' || name == 'undefined') {
        $('.generic-errors').html('Name field required.');
        return false;
    }
    if (email == '' || email == 'undefined') {
        $('.generic-errors').html('Email field required.');
        return false;
    }

    if (!$('#terms_conditions').prop('checked')) {
        $('.generic-errors').html('The terms conditions must be accepted.');
        return false;
    }
    if (re_amount == '' || eval(re_amount) < 1) {
        $('.generic-errors').html('Payable amount cannot be less than 1.');
        return false;
    }
    $('.generic-errors').html('');
});
</script>
@endsection


<style>
body {
    background: #f3f3f3 !important;
}

.pay-inr {
    background: #fff;
    padding: 10px 20px;
    margin: 20px 0;
    border-radius: 7px;
}

.pay-inr .form-control,
.pay-inr select.form-control {
    border: 1px solid #ddd;
    padding-left: 10px;
    font-size: 14px;
    box-shadow: none;
    border-radius: 5px;
}
</style>
@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-5 col-md-offset-4">
            <div class="pay-inr">
                <h2 class="text-left" style="color: #0053dc;"> Payment Details </h2>
                <hr>
                @if (session()->has('error'))
                <div class="text-danger font-italic">{{ session()->get('error') }}</div>
                @endif
                <form action="{{ url('billingorganization/pay-online') }}" method="post" id="payment-form">
                    @csrf
                    <input type="hidden" name="amount" value="{{$bill_rs->amount}}">

                    <input type="hidden" name="due_amonut" value="{{$bill_rs->due}}">
                    <input type="hidden" name="new_id" value="{{$payme_new->id}}">
                    <input type="hidden" name="in_id" value="{{$bill_rs->in_id}}">
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="name">Name on card</label>

                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="email">Email</label>

                            <input type="text" name="email" id="email" class="form-control"
                                value="{{$Roledata->email }}" readonly required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label>Billing Amount in Pound</label> <br>
                            <h2 class="text-muted">£ {{$bill_rs->amount}}</h2>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="re_amount">Payable Amount</label>

                            <input type="number" name="re_amount" id="re_amount" class="form-control"
                                value="{{$bill_rs->due}}" required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <!-- Display errors returned by createToken -->
                            <label>Card Number</label>
                            <div id="paymentResponse" class="text-danger font-italic"></div>
                            <div id="card_number" class="field form-control"></div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label>Expiry Date</label>
                            <div id="card_expiry" class="field form-control"></div>
                        </div>
                        <div class="col-md-4">
                            <label>CVC Code</label>
                            <div id="card_cvc" class="field form-control"></div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="form-check form-check-inline custom-control custom-checkbox">
                                <input type="checkbox" name="terms_conditions" id="terms_conditions"
                                    class="custom-control-input" required>
                                <label for="terms_conditions" class="custom-control-label">
                                    I agree to terms & conditions
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="text-danger font-italic generic-errors"></div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <input type="submit" value="Pay Now" class="btn btn-primary pay-via-stripe-btn">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection