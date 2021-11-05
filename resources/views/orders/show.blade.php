@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-shopping-bag nav-icon"></i> Commandes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Commande</a></li>
                        <li class="breadcrumb-item active"><strong>{{ $order->code }}</strong></li>
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
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Commande n° {{$order->id}}</h5>
                                        <small>date de création {{\Carbon\Carbon::parse($order->created_at)->locale('fr_FR')->isoFormat('LL')}}</small>
                                    </div>
                                    <p class="mb-1">
                                        <em>Client : <strong>{{ $order->client_name }}</strong></em>
                                    </p>
                                </div>
                                @if($order->proformas()->exists())

                                <div class="list-group-item">
                                    <p class="mb-1">
                                        Montant à payer : <strong>
                                            {{ number_format($order->proforma_amount, 2, ',',' ') }}
                                            {{ strtoupper($order->proforma_currency) }}
                                        </strong>
                                    </p>
                                    <p class="mb-1">
                                        Statut livrason : <strong>{{ trans('status.' . $order->delivery_status) }}</strong>
                                    </p>
                                    <p class="mb-1">
                                        Statut paiement : <strong>{{ trans('status.' . $order->payment_status) }}</strong>
                                    </p>
                                </div>
                                @endif

                                <div class="list-group-item">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                            <span class="fa fa-cog"></span> Actions sur la commande
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#"><span class="fa fa-times"></span> Annuler</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#staticBackdrop"><span class="fa fa-file-contract"></span> Etablir une proforma</a>
                                            <a class="dropdown-item" href="{{ route('proformas.download', $order->code) }}"><span class="fa fa-download"></span> Télécharger la pro forma</a>
                                            <a class="dropdown-item" href="#"><span class="fa fa-pen-square"></span> Changement statut de paiement</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <h6><i class="nav-icon fas fa-shopping-bag"></i> Détails de la commande</h6>
                                    <div class="table-responsive">
                                        <table class="table table-stripped">
                                            <thead>
                                            <tr>
                                                <th>Article</th>
                                                <th>URL</th>
                                                <th>Quantité</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->details as $item)
                                                <tr>
                                                    <td>{{ $item->product_name }}</td>
                                                    <td>{{ $item->product_url }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ $item->description }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>

    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Etablir une facture pro forma</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('proformas.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="amount">Montant à payer*</label>
                                <input required type="number" step="any" placeholder="montant" name="amount" id="amount" class="form-control"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="currency">Devise*</label>
                                <select required name="currency" id="currency" class="form-control">
                                    <option value="">Selectionner...</option>
                                    @foreach($currencies as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="attachment">Annexe pro forma*</label>
                                <input required type="file" name="attachment" accept="application/pdf" id="attachment" class="form-control"/>
                                <input type="hidden" name="order" value="{{ $order->id }}">
                            </div>
                        </div>
                        <div class="form-group text-md-end">
                            <hr>
                            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
