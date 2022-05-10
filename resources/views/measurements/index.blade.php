@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Paramètres de simulation des prix</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Simulation</li>
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
                        <div class="card-body">

                            <p>
                                <a href="#" data-toggle="modal" data-target="#staticBackdrop" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Définir les paramètres</a>
                            </p>

                            <p></p>

                            <div class="row">
                                <div class="col-md-6">

                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td><strong>Longueur </strong></td>
                                            <td> {{ $measurement ? $measurement->length . ' EUR/ cm' : "Non défini" }} </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Largeur </strong></td>
                                            <td> {{ $measurement ? $measurement->width . 'EUR/ cm' : "Non défini" }} </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Hauteur </strong></td>
                                            <td> {{ $measurement ? $measurement->height . 'EUR/ cm' : "Non défini" }} </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Poids </strong></td>
                                            <td> {{ $measurement ? $measurement->weight . 'EUR/ kg' : "Non défini" }} </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Paramètre de simulation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('measurements.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputNumber1">Longueur*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">CM</div>
                                    </div>
                                    <input type="text" class="form-control" min="0" name="length" required autocomplete="off" id="exampleInputNumber1" placeholder="longueur">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputNumber2">Largeur*</label>
                                <input required placeholder="largeur" type="number" min="0" step="any" autocomplete="off"
                                       class="form-control" name="width" id="exampleInputNumber2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputNumber3">Hauteur*</label>
                                <input required placeholder="hauteur" type="number" min="0" step="any" autocomplete="off"
                                       class="form-control" name="height" id="exampleInputNumber3">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputNumber4">Poids*</label>
                                <input required placeholder="poids" type="number" min="0" step="any" autocomplete="off"
                                       class="form-control" name="weight" id="exampleInputNumber4">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><span class="fa fa-plus fa-fw"></span> Ajouter</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

@endsection
