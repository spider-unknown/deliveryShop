@extends('modules.admin.layouts.app-full')
@section('content')
    <h1 class="h2 mb-2">Заказы</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Заказы</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 mb-5">
            <div class="card h-100">
                <header class="card-header">
                    <h2 class="h4 card-header-title">Заказы</h2>
                </header>
                <div class="card-body pt-0">
                    @if($orders->items())
                        <table class="table table-hover table-light text-center">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Пользователь</th>
                                <th>Адрес</th>
                                <th>Статус</th>
                                <th>Сумма</th>
                                <th>Создан</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->user->name. ' ' .$order->user->surname }}</td>
                                    <td>{{$order->address->city->name. ' ' .$order->address->address}}</td>
                                    <td>@if($order->status == 0)В ожиданиий
                                            @elseif($order->status == 1) Принят
                                            @elseif($order->status == 2) Доставлен
                                        @endif
                                    </td>
                                    <td>{{$order->total_amount}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td class="d-inline-block">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$orders->links()}}
                    @else <h6>У вас пока нет заказов!</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
