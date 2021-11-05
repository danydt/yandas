@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Devises</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Devises</li>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><a href="{{ route('currencies.create') }}" class="btn btn-secondary">Ajouter une devise</a></h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Rechercher">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <p>&nbsp;</p>

                            <div class="col float-right">
                                {!! $currencies->links() !!}
                            </div>

                            <table class="table table-sm table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th>Code</th>
                                    <th>Nom</th>
                                    <th style="width: 5%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($currencies as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ strtoupper($item->code) }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td><a href="{{ route('currencies.show', $item->code) }}">
                                                <span class="fas fa-eye fa-fw"></span>
                                            </a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"><em>Aucune devise</em></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>

@endsection
