@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-users nav-icon"></i> Utilisateurs</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Utilisateurs</a></li>
                        <li class="breadcrumb-item active"><strong>{{ $user->name }}</strong></li>
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
                                        <h5 class="mb-1">{{ $user->name . ' ' . $user->code }}</h5>
                                        <small>date de création {{\Carbon\Carbon::parse($user->created_at)->locale('fr_FR')->isoFormat('LL')}}</small>
                                    </div>
                                    <p class="mb-1">{{ $user->role_name }} | <em>{{ $user->email }}</em></p>
                                </a>
                            </div>
                            <hr>

                            <p>
                                <span class="fa fa-pen-square"></span> <a href="{{ route('users.edit', $user->code) }}">Modifier les informations</a>
                            </p>

                            <table class="table table-sm">
                                <thead>
                                <tbody>
                                <tr>
                                    <td style="width: 10%"><strong>Rôle</strong></td><td>{{ $user->role_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Entité</strong></td>
                                    <td>{{ $user->entity_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Matricule</strong></td>
                                    <td>{{ $user->code }}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>

@endsection
