@extends('layouts.main')

@section('title', 'Commandes')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

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
                        <li class="breadcrumb-item active">Commandes</li>
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

                            @if(auth()->user()->user_type == "customer")
                                <p>
                                    <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                        <i class="fa fa-cart-plus"></i> Nouvelle commande</a>
                                </p>
                            @endif

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    {!! $orders->links() !!}
                                </div>
                            </div>

                            <div class="col">
                                <p><span class="fa fa-search"></span> Rechercher une commande</p>

                                <div class="input-group">

                                    <select aria-label="search account" name="search_account" id="search_account"
                                            class="form-control"></select>
                                </div>
                            </div>

                            <p></p>

                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Numéro</th>
                                    <th scope="col">Date commande</th>
                                    @if(auth()->user()->user_type == "admin")
                                    <th scope="col">Client</th>
                                    @endif
                                    <th scope="col">Nombre d'articles</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col" style="width: 10%;" class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->external_code }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->locale('fr_FR')->isoFormat('LL') }}</td>
                                    @if(auth()->user()->user_type == "admin")
                                            <td>{{ $order->client_name }}</td>
                                        @endif
                                        <td>{{ $order->detail_count }}</td>
                                        <td>
                                            @if($order->proforma_amount > 0 )
                                                @if($order->paid_amount == 0)
                                                En attente de paiement
                                                @elseif($order->paid_amount < $order->proforma_amount)
                                                    En attente de solde
                                                @endif
                                            @else
                                            En attente
                                                @endif

                                        </td>
                                        <td class="text-right">
                                            <a title="afficher" href="{{ route('orders.show', $order->internal_code) }}">
                                                <span class="fa fa-eye"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"><em>Aucune commande !</em></td>
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

    <input type="hidden" id="finding" value="{{ route('orders.show', 1) }}">

@endsection

@section('js')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script>
        const order = $('#search_account');

        order.on('select2:select', function () {

            const order_item = $(this).children().last().val();

            if (order_item !== "") {

                let search_url = $('#finding').val();

                document.location.href = search_url.substring(0, search_url.lastIndexOf("/")) + "/" + order_item;
            }
        });

        order.select2({
            ajax: {
                url: "{{ route('orders.search') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            multiple: true,
            placeholder: 'Saisissez le numéro de la commande...',
            minimumInputLength: 3,
            allowClear: true,
            language: "fr",
            width: '100%',
            templateResult: formatRepo,
            templateSelection: formatRepoSelection

        });

        function formatRepo(repo) {
            if (repo.loading) {
                return repo.text;
            }

            let $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'></div>" +
                "<div class='select2-result-repository__description'></div>" +
                "</div>" +
                "</div>"
            );

            $container.find(".select2-result-repository__title").text(repo.name);
            $container.find(".select2-result-repository__description").text(repo.code);

            return $container;
        }

        function formatRepoSelection(repo) {

            return repo.name || repo.text;
        }
    </script>
@endsection
