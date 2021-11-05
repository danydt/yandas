@extends('layouts.main')

@section('content')
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
                        <li class="breadcrumb-item"><a href="{{ route('currencies.show', $currency->code) }}">{{ $currency->name }}</a></li>
                        <li class="breadcrumb-item active">Modification devise</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Modification d'une devise</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="post" action="{{ route('currencies.update', $currency->code) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="exampleInputText2">Code*</label>
                                        <input autofocus value="{{ strtoupper($currency->code) }}" required placeholder="code" type="text" autocomplete="off"
                                               class="form-control" name="code" id="exampleInputText2">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="exampleInputText3">Nom*</label>
                                        <input value="{{ $currency->name }}" required placeholder="nom complet" type="text" autocomplete="off"
                                               class="form-control" name="name" id="exampleInputText3">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><span class="fa fa-plus fa-fw"></span> Enregistrer</button>
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
