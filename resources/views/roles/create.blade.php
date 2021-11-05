@extends('layouts.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-cubes nav-icon"></i> Rôles</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Rôles</a></li>
                        <li class="breadcrumb-item active">Nouveau rôle</li>
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
                            <h3 class="card-title">Création d'un nouveau rôle</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="post" action="{{ route('roles.store') }}">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="exampleInputText1">Nom</label>
                                        <input autofocus required placeholder="nom du rôle" type="text" autocomplete="off"
                                               class="form-control" name="name" id="exampleInputText1">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputText2">Tableau de bord</label>
                                        <input required placeholder="tableau de bord" type="text" autocomplete="off"
                                               class="form-control" name="dashboard" id="exampleInputText2">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="exampleInputText3">Navigation</label>
                                        <input required placeholder="barre de navigation" type="text" autocomplete="off"
                                               class="form-control" name="navigation" id="exampleInputText3">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputText4">Menus</label>
                                        <input required placeholder="barre de menus" type="text" autocomplete="off"
                                               class="form-control" name="sidebar" id="exampleInputText3">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><span class="fa fa-plus fa-fw"></span> Ajouter</button>
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
