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
                                        <small>date de
                                            création {{\Carbon\Carbon::parse($order->created_at)->locale('fr_FR')->isoFormat('LL')}}</small>
                                    </div>
                                    <p class="mb-1">
                                        <em>Client : <strong>{{ $order->client_name }}</strong></em>
                                    </p>
                                    <p class="mb-1">
                                        <em>Statut de la commande :
                                            <strong>{{ $order->enabled ? 'Active' : "Annulée" }}</strong></em>
                                    </p>
                                </div>
                                @if($order->proformas()->exists())

                                    <div class="list-group-item">
                                        <p class="mb-1">
                                            Payement : <strong>
                                                {{ number_format($order->paid_amount, 2, ',',' ') }} EUR
                                                / {{ number_format($order->proforma_amount, 2, ',',' ') }}
                                                {{ strtoupper($order->proforma_currency) }}
                                            </strong>
                                        </p>
                                        <p class="mb-1">
                                            Statut livrason :
                                            <strong>{{ trans('status.' . $order->delivery_status) }}</strong>
                                        </p>
                                        <p class="mb-1">
                                            Statut paiement :
                                            <strong>{{ trans('status.' . $order->payment_status) }}</strong>
                                        </p>
                                    </div>
                                @endif

                                @if($order->enabled)
                                    <div class="list-group-item">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                <span class="fa fa-cog"></span> Actions sur la commande
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if(auth()->user()->user_type == "customer")
                                                    @if($order->enabled)
                                                        <a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                     document.getElementById('cancel-form').submit();"><span
                                                                class="fa fa-times"></span> Annuler</a>

                                                        <form id="cancel-form"
                                                              action="{{ route('orders.cancel', $order->code) }}"
                                                              method="POST" style="display: none;">
                                                            @csrf
                                                            @method('PATCH')
                                                        </form>
                                                    @endif
                                                    @if($order->proforma_code)
                                                        <a class="dropdown-item"
                                                           href="{{ route('proformas.download', $order->proforma_code) }}"><span
                                                                class="fa fa-download"></span> Télécharger la pro forma</a>
                                                        <a class="dropdown-item" href="#"><span
                                                                class="fa fa-credit-card"></span> Payer</a>
                                                    @endif
                                                @endif
                                                @if(auth()->user()->user_type == "admin" && $order->enabled)
                                                    @if ($order->paid_amount == 0)
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                           data-target="#staticBackdrop"><span
                                                                class="fa fa-file-contract"></span> Etablir une
                                                            proforma</a>
                                                    @endif
                                                    <a class="dropdown-item" href="#"><span
                                                            class="fas fa-sync-alt"></span>
                                                        Changement statut de livraison</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-12">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                               role="tab" aria-controls="home" aria-selected="true"><i
                                                    class="nav-icon fas fa-shopping-bag"></i> Détails de la commande</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                               role="tab" aria-controls="profile" aria-selected="false"><i
                                                    class="nav-icon fas fa-credit-card"></i> Paiements</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact"
                                               role="tab" aria-controls="contact" aria-selected="false"><i
                                                    class="nav-icon fas fa-truck"></i> Livraison</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">

                                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                                             aria-labelledby="home-tab">
                                            <br>
                                            <div class="table-responsive">
                                                <table class="table table-stripped">
                                                    <thead>
                                                    <tr>
                                                        <th>Article</th>
                                                        <th>URL</th>
                                                        <th>Quantité</th>
                                                        <th>Description</th>
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

                                        <div class="tab-pane fade" id="profile" role="tabpanel"
                                             aria-labelledby="profile-tab">
                                            <br>
                                            <div class="table-responsive">
                                                <table class="table table-stripped">
                                                    <thead>
                                                    <tr>
                                                        <th>Date paiement</th>
                                                        <th>Montant payé</th>
                                                        <th>Référence paiement</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($order->payments as $item)
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($item->payment_date)->locale('fr_FR')->isoFormat('LL') }}</td>
                                                            <td>{{ number_format($item->paid_amount, 2, ',', ' ') }} {{ strtoupper($order->proforma_currency) }}</td>
                                                            <td>{{ $item->reference_code }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3"><em>Aucun paiement</em></td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="contact" role="tabpanel"
                                             aria-labelledby="contact-tab">
                                            <br>

                                            <table class="table table-stripped">
                                                <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($order->followings as $item)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('fr_FR')->isoFormat('LL') }}</td>
                                                        <td>{{ $item->description }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2"><em>Aucun détail</em></td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
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

    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Etablir une facture pro forma</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p>
                        Si vous établissez une nouvelle facture pro forma, l'ancienne sera annulée.
                    </p>
                    <form action="{{ route('proformas.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="amount">Montant à payer*</label>
                                <input required type="number" step="any" placeholder="montant" name="amount" id="amount"
                                       class="form-control"/>
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
                                <input required type="file" name="attachment" accept="application/pdf" id="attachment"
                                       class="form-control"/>
                                <input type="hidden" name="order" value="{{ $order->id }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="modality">Pourcentage du premier paiement*</label>
                                <input required type="number" step="any" placeholder="modalités de paiement"
                                       name="modality" id="modality" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group text-md-end">
                            <hr>
                            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
