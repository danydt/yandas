@extends('layouts.main')

@section('title', 'Nouvelle commande')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5><i class="fa fa-cart-plus"></i> Nouvelle commande</h5>
                    <span>Veuillez remplir le formulaire ci-après et cliquer sur le bouton "<strong>Ajouter</strong>".</span>
                    <span>Vous cliquerez en suite sur le bouton "<strong>Enregistrer</strong>" pour valider votre commande.</span>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlInput1">Nom de l'article</label>
                                <input class="form-control" id="exampleFormControlInput1" required autofocus
                                       autocomplete="off" value="{{ old('name') }}" type="text"
                                       placeholder="Nom de votre article">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="mb-3">
                                <label class="form-label" for="exampleInputUrl1">URL du site</label>
                                <input class="form-control" id="exampleInputUrl1" required type="url" name="url"
                                       value="{{ old('url') }}"
                                       placeholder="ex: https://www.biso243.com/product/boisson-athena-ventre-plat/">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <div class="mb-3">
                                <label class="form-label" for="exampleInputNumber1">Quantité</label>
                                <input placeholder="Quantité" min="1" class="form-control" id="exampleInputNumber1"
                                       required type="number" name="quantity" value="{{ old('quantity') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <div>
                                <label class="form-label" for="exampleFormControlTextarea4">Autres détails</label>
                                <textarea class="form-control" id="exampleFormControlTextarea4" rows="5"
                                          placeholder="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="form-group">
                            <button class="btn btn-primary" type="button"><i class="fa fa-plus"></i> Ajouter</button>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <h4>Votre panier</h4>
                    <form action="{{ route('orders.store') }}" method="post">
                        @csrf
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
                                <tbody></tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="text-end">
                            <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/handle-order.js') }}"></script>
@endsection
