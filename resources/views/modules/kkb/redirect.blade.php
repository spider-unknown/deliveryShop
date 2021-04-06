<!DOCTYPE html>
<html>
<head>
    <title>Epay redirect</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <style type="text/css">
        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            top: 50%;
            position: absolute;
            left: 50%;
            margin-top: -76px;
            margin-left: -76px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

</head>
<body onload="document.form.submit()">
<form method="POST" action="{{$url}}" name="form">
    <input type="text" name="Signed_Order_B64" value="{{$signed_order_b64}}" hidden>
    <input type="text" name="Language" value="rus" hidden>
    @if (isset($email))
        <input type="text" name="email" value="{{$email}}" hidden>
    @endif
    <input type="text" name="PostLink" value="{{$post_link}}" hidden>
    <input type="text" name="BackLink" value="{{$back_link}}" hidden>
    <input type="text" name="FailureBackLink" value="{{$failure_link}}" hidden>
</form>


<div class="loader"></div>

</body>
</html>
