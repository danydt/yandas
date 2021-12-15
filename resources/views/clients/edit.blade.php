@extends('layouts.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-users nav-icon"></i> Clients</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('clients.show', $client->email) }}">{{ $client->name }}</a></li>
                        <li class="breadcrumb-item active">Modification client</li>
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
                            <h3 class="card-title">Modification détails client</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="post" action="{{ route('clients.update', $client->email) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputText2">Nom*</label>
                                        <input value="{{ $client->name }}" required placeholder="nom complet" type="text" autocomplete="off"
                                               class="form-control" name="name" id="exampleInputText2">
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
