@extends('layouts.main')

@section('title', 'Commandes')

@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3><i data-feather="shopping-cart"></i> Commandes</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Commandes</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                   data-placement="top" title="" data-original-title="Tables"><i
                                        data-feather="inbox"></i></a></li>
                            <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                   data-placement="top" title="" data-original-title="Chat"><i
                                        data-feather="message-square"></i></a></li>
                            <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                   data-placement="top" title="" data-original-title="Icons"><i
                                        data-feather="command"></i></a></li>
                            <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                   data-placement="top" title="" data-original-title="Learning"><i
                                        data-feather="layers"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="bookmark-search" data-feather="star"></i></a>
                                <form class="form-inline search-form">
                                    <div class="form-group form-control-search">
                                        <input type="text" placeholder="Search..">
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <!-- Bookmark Ends-->
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Commandes</h5>
                        <span>Vous avez au total <strong>{{ sizeof($orders) }}</strong> commandes.</span>
                        <a class="btn btn-primary" href="{{ route('orders.create') }}">
                            <i class="fa fa-cart-plus"></i> Nouvelle commande</a>
                    </div>
                    <div class="card-block row">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-primary">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Date commande</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->code }}</td>
                                            <td>{{ $order->client_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->locale('fr_FR')->isoFormat('LL') }}</td>
                                            <td>
                                                <a href="{{ route('orders.show', $order->code) }}">
                                                    <i data-feather="menu"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"><em>Aucune commande !</em></td>
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
    <!-- Container-fluid Ends-->

@endsection
