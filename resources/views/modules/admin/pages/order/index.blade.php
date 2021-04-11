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
                                <th>Телефон</th>
                                <th>Адрес</th>
                                <th>Статус</th>
                                <th>Сумма</th>
                                <th>Курьер</th>
                                <th>Оплата</th>
                                <th>Оплачен</th>
                                <th>Создан</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->user->name. ' ' .$order->user->surname }}</td>
                                    <td>{{$order->user->phone}}</td>
                                    <td>{{$order->address->city->name. ' ' .$order->address->address}}</td>
                                    <td>@if($order->status == 0)<span
                                            class="badge badge-pill badge-danger">В ожиданиий</span>
                                        @elseif($order->status == 1) <span
                                                class="badge badge-pill badge-warning">Принят</span>
                                        @elseif($order->status == 2) <span class="badge badge-pill badge-success">Доставлен</span>
                                        @endif
                                    </td>
                                    <td>{{$order->total_amount}}</td>
                                    <td><span
                                            class="badge badge-pill badge-grey">{{$order->courier ? 'Да' : 'Нет'}}</span>
                                    </td>
                                    <td><span
                                            class="badge badge-pill badge-grey">{{$order->cash ? 'Наличными' : 'Картой'}}
                                    <td><span class="badge badge-pill badge-grey">{{$order->transaction_detail
? $order->transaction_detail['status'] == 1 ? 'Оплачено' : 'Не оплачено' : 'Наличными'}}
                                        </span></td>
                                    <td>{{$order->created_at}}</td>
                                    <td class="d-flex">
                                        <a href="{{route('order.show', ['id' => $order->id])}}"
                                           class="btn btn-outline-primary btn-sm mr-1 mb-1">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        @if($order->status == 0)
                                            <form action="{{route('order.accept')}}" method="POST">
                                                {{csrf_field()}}
                                                <input type="number" name="id" hidden value="{{$order->id}}">
                                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                                    Принять<i class="ti ti-check"></i>
                                                </button>
                                            </form>
                                        @elseif($order->status == 1)
                                            <form action="{{route('order.delivered')}}" method="POST">
                                                {{csrf_field()}}
                                                <input type="number" name="id" hidden value="{{$order->id}}">
                                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                                    Доставлен<i class="ti ti-check"></i>
                                                </button>
                                            </form>
                                        @endif
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
