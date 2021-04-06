<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <title>Магазин</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('modules/admin/assets/css/theme.css')}}">
    <style>
        .main {
            margin: 20px;
        }
        .card {
            border-radius: 15px;
        }

        .card-header {
            border-bottom: 2px solid #a7a7a7;
            background-color: #ec4d4d;
        }

        img {
            width: 70px;
            height: 70px;
        }
    </style>
</head>
<body>
<div class="main">
    <div class="card m-auto border col-12 col-md-7 p-0">
        <div class="card-header text-center">
            <img src="{{asset('modules/admin/assets/img/error.png')}}">
        </div>
        <div class="card-body">
            <h3 class="text-center">{{isset($error) ? $error : 'Произошла ошибка!'}}</h3>
            <p>Номер транзакции</p>
            <p>Номер транзакции</p>
            <p>Номер транзакции</p>
        </div>
    </div>
</div>
</body>
</html>
