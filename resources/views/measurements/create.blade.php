@extends('layouts.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-tools nav-icon"></i> Simulateur de prix</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Simulateur de prix</li>
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
                            <h3 class="card-title">Simulateur de prix</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form onsubmit="return estimate(this)" method="post" action="{{ route('measurements.simulate') }}">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="exampleInputNumber1">Longueur*</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input type="number" min="0" step="any" class="form-control" name="length" required
                                                   autocomplete="off" value="0" id="exampleInputNumber1" placeholder="longueur">
                                            <div class="input-group-append">
                                                <div class="input-group-text">CM</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputNumber2" class="col-sm-2 col-form-label">Largeur*</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input type="number" min="0" step="any" class="form-control" name="width" required
                                                   autocomplete="off" value="0" id="exampleInputNumber2" placeholder="largeur">
                                            <div class="input-group-append">
                                                <div class="input-group-text">CM</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputNumber3" class="col-sm-2 col-form-label">Hauteur</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input type="number" min="0" value="0" step="any" class="form-control" name="height" required
                                                   autocomplete="off" id="exampleInputNumber3" placeholder="hauteur">
                                            <div class="input-group-append">
                                                <div class="input-group-text">CM</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputNumber4" class="col-sm-2 col-form-label">Poids</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input type="number" min="0" value="0" step="any" class="form-control" name="weight" required
                                                   autocomplete="off" id="exampleInputNumber4" placeholder="poids">
                                            <div class="input-group-append">
                                                <div class="input-group-text">KG</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="offset-2">
                                        <button type="submit" class="btn btn-primary">Calculer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <h3 class="text-center"></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('js')
    <script>
        function estimate(_form) {

            let button = $('button[type="submit"]'), label = $('h3.text-center');

            button.attr('disabled', 'disabled').text('Traitement en cours...');
            label.empty();

            $.post(_form.action, $(_form).serialize()).done(function (result) {

                button.removeAttr('disabled').text('Calculer');

                label.text(result);
            });


            return false;
        }
    </script>
@endsection
