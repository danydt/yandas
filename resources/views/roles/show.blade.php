@extends('layouts.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-cog nav-icon"></i> Rôles</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Rôles</a></li>
                        <li class="breadcrumb-item active">{{ $role->name }}</li>
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
                            <h3 class="card-title">Détail rôle</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="list-group">
                                <a href="#" onclick="return false" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{$role->name}}</h5>
                                        <small>date de création {{\Carbon\Carbon::parse($role->created_at)->locale('fr_FR')->isoFormat('LL')}}</small>
                                    </div>
                                    <p class="mb-1">{{$role->code}}</p>
                                    <p class="mb-1"><em>dernière
                                            mise à jour {{\Carbon\Carbon::parse($role->updated_at)->locale('fr_FR')->diffForHumans()}}</em>
                                    </p>
                                </a>
                            </div>
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
