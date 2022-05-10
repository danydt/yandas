@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-map-marker nav-icon"></i> Mon adresse de livraison</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active"><strong>Mon adresse de livraison</strong></li>
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

                            @if($address)

                                <table class="table table-sm">
                                    <thead>
                                    <tbody>
                                    <tr>
                                        <td style="width: 20%"><strong>Nom complet</strong></td>
                                        <td>{{ $user->name }} #{{ $user->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pays</strong></td>
                                        <td>{{ $address->country_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Adresse ligne 1</strong></td>
                                        <td>{{ $address->address_l1 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Adresse ligne 2</strong></td>
                                        <td>{{ $address->address_l2 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Téléphone</strong></td>
                                        <td>{{ $address->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Code postal</strong></td>
                                        <td>{{ $address->postal_code }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                            @else
                                <h3>L'administrateur n'a pas encore définit l'addresse.</h3>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>

@endsection
