@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Devises</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('currencies.index') }}">Devises</a></li>
                        <li class="breadcrumb-item active"><strong>{{ $currency->name }}</strong></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">

                            <div class="list-group">
                                <a href="#" onclick="return false" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $currency->name . ' (' . \Illuminate\Support\Str::upper($currency->code) . ')' }}</h5>
                                        <small>date de
                                            création {{\Carbon\Carbon::parse($currency->created_at)->locale('fr_FR')->isoFormat('LL')}}</small>
                                    </div>
                                    <p class="mb-1"><em>dernière
                                            mise à jour {{\Carbon\Carbon::parse($currency->updated_at)->locale('fr_FR')->diffForHumans()}}</em>
                                    </p>
                                </a>
                            </div>
                            <hr>

                            <p>
                                <span class="fa fa-pen-square"></span> <a
                                    href="{{ route('currencies.edit', $currency->code) }}">Modifier les informations</a>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>

@endsection
