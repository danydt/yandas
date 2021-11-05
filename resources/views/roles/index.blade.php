@extends('layouts.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-stream nav-icon"></i> Rôles</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Rôles</li>
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
                            <h3 class="card-title">Liste de rôles</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <p>
                                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                    <span class="fa fa-plus fa-fw"></span> Nouveau rôle</a>
                            </p>

                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Code</th>
                                    <th>Nom du rôle</th>
                                    <th>Est Actif</th>
                                    <th style="width: 8%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($roles as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @if($item->enabled)
                                                <span class="fas fa-check"></span>
                                            @else
                                                <span class="fas fa-times"></span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('roles.show', $item->code) }}">
                                                <span class="fas fa-bars"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"><em>Aucun rôle !</em></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
