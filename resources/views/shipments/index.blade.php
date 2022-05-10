@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Adresse de livraison</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Adresse de livraison</li>
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
                            <p>
                                <a href="#" data-toggle="modal" data-target="#staticBackdrop" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Définir l'adresse de livraison</a>
                            </p>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">

                                    <table class="table table-borderless">
                                        <tbody>
                                        <tr>
                                            <td><strong>Pays </strong></td>
                                            <td> {{ $address ? $address->country_name : "Non défini" }} </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Adresse ligne 1 </strong></td>
                                            <td> {{ $address ? $address->address_l1 : "Non définie" }} </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Adresse ligne 2 </strong></td>
                                            <td> {{ $address ? $address->address_l2 : "Non définie" }} </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Téléphone </strong></td>
                                            <td> {{ $address ? $address->phone_number : "Non défini" }} </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Code postal </strong></td>
                                            <td> {{ $address ? $address->postal_code : "Non défini" }} </td>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Adresse de livraison</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('shipments.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputText1">Pays*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><span class="fa fa-globe"></span></div>
                                    </div>
                                    <input type="text" class="form-control" name="country" required autocomplete="off" id="exampleInputText1" placeholder="pays">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputText2">Adresse ligne 1*</label>
                                <input required placeholder="adresse ligne 1" type="text" autocomplete="off"
                                       class="form-control" name="line1" id="exampleInputText2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputText3">Adresse ligne 2</label>
                                <input placeholder="adresse ligne 2" type="text" autocomplete="off"
                                       class="form-control" name="line2" id="exampleInputText3">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputTel1">Téléphone*</label>
                                <input required placeholder="téléphone" type="tel" autocomplete="off"
                                       class="form-control" name="phone" id="exampleInputTel1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputText4">Code postal*</label>
                                <input required placeholder="code postal" type="text" autocomplete="off"
                                       class="form-control" name="postal" id="exampleInputText4">
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
