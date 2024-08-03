<!DOCTYPE html>
<html>

<head>
    <title>Telnyx WebRTC Call </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Cross Browser WebRTC Adapter -->
    <script src="https://unpkg.com/africastalking-client@1.0.7/build/africastalking.js"></script>


    <!-- To style up the demo a little -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<body style="padding: 0px; margin: 0px; background-color: #FFC700;">
<div class="container" style="background-color: #FFC700; max-width: 400px; display: flex; flex-direction: column; align-items: center; justify-content: center; height:100vh">


    <div class="d-flex justify-content-center">

        <form method="POST" action="https://checkout.flutterwave.com/v3/hosted/pay" >
            <div>
                You are about to pay  NGN {{number_format($amount, 2)}}
            </div>
            <input type="hidden" name="public_key" value="{{$key}}" />
            <input type="hidden" name="customer[email]" value="{{$email}}" />
            <input type="hidden" name="customer[name]" value="MOMAS" />
            <input type="hidden" name="tx_ref" value="{{$trx_id}}" />
            <input type="hidden" name="amount" value="{{$amount}}" />
            <input type="hidden" name="currency" value="NGN" />
            <input type="hidden" name="meta[source]" value="docs-html-test" />
            <input type="hidden" name="redirect_url" value="{{url('')}}/payment-check" />
            <br>
            <button class="btn btn-dark w-100"  type="submit" id="start-payment-button">Pay Now</button>
        </form>

    </div>


</body>

</html>
