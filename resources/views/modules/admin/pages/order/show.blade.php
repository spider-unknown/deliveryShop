@extends('modules.admin.layouts.app-full')
@section('content')
    <h1 class="h2 mb-2">Заказ</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Заказ</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 mb-5">
            <div class="card h-100">
                <header class="card-header">
                    <a href="{{route('order.index')}}" class="btn btn-outline-primary mt-1 mb-4"><i
                            class="ti ti-arrow-left"></i> Назад</a>
                    <h2 class="h4 card-header-title">Детали заказа</h2>
                </header>
                <div class="card-body pt-0">
                    <label>Номер заказа: <b>№{{$order->id}}</b></label>
                    <hr>
                    <label><b>Статус:</b>
                        @if($order->status == 0)
                            <span class="badge badge-pill badge-danger">В ожидании</span>
                            @elseif($order->status == 1)
                            <span class="badge badge-pill badge-warning">Принят</span>
                        @elseif($order->status == 2)
                            <span class="badge badge-pill badge-success">Доставлен</span>
                        @endif
                    </label>
                    <hr>
                    <label><b>Общая сумма:</b> {{$order->total_amount}} KZT</label>
                    <hr>
                    <label><b>Общее количество</b>: {{$order->total_quantity}}</label>
                    <hr>
                    <label><b>Пользователь:</b> {{$order->user->name. ' ' .$order->user->surname }}</label>
                    <hr>
                    <label><b>Номер телефона:</b> +{{$order->user->phone}}</label>
                    <hr>
                    <label><b>Адрес:</b> {{'г.'.$order->address->city->name. ', ' .$order->address->address
                    .', '.$order->address->comment }}</label>
                    <hr>
                    <label><b>Курьер:</b> {{$order->courier ? 'Да' : 'Нет'}}</label>
                    <hr>
                    <label><b>Оплата:</b> {{$order->cash ? 'Наличными' : 'Картой'}}</label>
                    <hr>
                    <label><b>Детали заказа:</b></label>
                    <br>
                    @foreach($order->details as $detail)
                        <label><b>Продукт:</b> {{$detail->product->name}}</label>
                        <br>
                        <label><b>Количество:</b> {{$detail->quantity}}</label>
                        <br>
                        <label><b>Сумма:</b> {{$detail->total_price}}</label>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
