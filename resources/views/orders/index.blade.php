@extends('layouts.main')

@section('title', 'Commandes')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-shopping-bag nav-icon"></i> Commandes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Entités</li>
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
                            <h3 class="card-title">Liste de commandes</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <p>
                                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                    <i class="fa fa-cart-plus"></i> Nouvelle commande</a>
                            </p>

                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Articles</th>
                                    <th scope="col">Date commande</th>
                                    <th scope="col" style="width: 10%;" class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->code }}</td>
                                        <td>{{ $order->client_name }}</td>
                                        <td>{{ $order->detail_count }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->locale('fr_FR')->isoFormat('LL') }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('orders.show', $order->code) }}">
                                                <span class="fa fa-bars"></span>
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
    </section>

@endsection
