@extends('modules.admin.layouts.app-full')
@section('content')
    <h1 class="h2 mb-2">Cтраны/Города</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Страны</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 mb-5">
            <div class="card h-100">
                <header class="card-header">
                    <h2 class="h4 card-header-title">Страны</h2>
                    <button class="btn btn-outline-primary mt-3" data-toggle="modal"
                            data-target="#addcountry">Добавить <i class="ti ti-plus"></i></button>
                </header>
                <div class="card-body pt-0">
                    @if(!$countries->isEmpty())
                        <table class="table table-hover table-light text-center">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Создан</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($countries as $country)
                                <tr>
                                    <td>{{$country->id}}</td>
                                    <td>{{$country->name}}</td>
                                    <td>{{$country->created_at}}</td>
                                    <td class="d-inline-block">
                                        <a href="{{route('city.index', ['country_id' => $country->id])}}" class="btn btn-outline-primary btn-sm">
                                            <i class="ti ti-menu"></i> </a>
                                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                                data-target="#editcountry{{$country->id}}"><i class="ti ti-pencil"></i>
                                        </button>
{{--                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal"--}}
{{--                                                data-target="#delete{{$country->id}}"><i class="ti ti-trash"></i>--}}
{{--                                        </button>--}}
{{--                                        <div class="modal modal-backdrop" id="delete{{$country->id}}" tabindex="-1"--}}
{{--                                             role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">--}}
{{--                                            <div class="modal-dialog" role="document">--}}
{{--                                                <div class="modal-content">--}}
{{--                                                    <div class="modal-header">--}}
{{--                                                        <h4 class="modal-title w-100" id="myModalLabel">Удаление</h4>--}}
{{--                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                                            <span aria-hidden="true">&times;</span>--}}
{{--                                                        </button>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-body">--}}
{{--                                                        <p>Вы действительно хотите удалить?</p>--}}
{{--                                                        <form method="post" action="{{route('country.delete', ['id' => $country->id])}}">--}}
{{--                                                            {{csrf_field()}}--}}
{{--                                                            <input type="number" value="{{$country->id}}" hidden>--}}
{{--                                                            <button type="submit" class="btn btn-outline-danger mt-3">Удалить безвозвратно<i class="ti ti-trash"></i></button>--}}
{{--                                                        </form>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-footer">--}}
{{--                                                        <button type="button" class="btn btn-danger-soft btn-sm" data-dismiss="modal">--}}
{{--                                                            <i class="ti ti-close"></i> Закрыть</button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </td>
                                </tr>
                                <div class="modal modal-backdrop" id="editcountry{{$country->id}}" tabindex="-1"
                                     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title w-100" id="myModalLabel">Редактировать категорию</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form action="{{route('country.update')}}" method="post">
                                                    <x-admin.input-form-group-list
                                                        :errors="$errors"
                                                        :elements="\App\Http\Forms\Web\V1\CountryWebForm::inputGroups($country)"/>
                                                    <button type="submit" class="offset-md-4 col-md-4 btn btn-block btn-wide btn-primary text-uppercase">
                                                        Сохранить <i class="ti ti-check"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger-soft btn-sm" data-dismiss="modal">
                                                    <i class="ti ti-close"></i> Закрыть</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                            </tbody>
                        </table>
                    @else <h6>У вас пока нет стран!</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-backdrop" id="addcountry" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title w-100" id="myModalLabel">Добавить страну</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('country.store')}}" method="post">
                        <x-admin.input-form-group-list
                            :errors="$errors"
                            :elements="$country_web_form"/>
                        <button type="submit" class="offset-md-4 col-md-4 btn btn-block btn-wide btn-primary text-uppercase">
                            Сохранить <i class="ti ti-check"></i>
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger-soft btn-sm" data-dismiss="modal">
                        <i class="ti ti-close"></i> Закрыть</button>
                </div>
            </div>
        </div>
    </div>
@endsection
