@extends('layouts.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="{{ $privilege->icon }}"></i> {{ $privilege->name }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Rôles</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.show', $role->code) }}">{{ $role->name }}</a></li>
                        <li class="breadcrumb-item active"><strong>{{ $privilege->name }}</strong></li>
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
                            <h3 class="card-title">Configuration du privilège</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{$role->name}}</h5>
                                        <small>date de création {{\Carbon\Carbon::parse($role->created_at)->locale('fr_FR')->isoFormat('LL')}}</small>
                                    </div>
                                    <p class="mb-1">{{$role->code}}</p>
                                    <p class="mb-1"><em>dernière
                                            mise à jour {{\Carbon\Carbon::parse($role->updated_at)->locale('fr_FR')->diffForHumans()}}</em>
                                    </p>
                                </a>
                            </div>
                            <hr>
                            <h6><i class="fas fa-lock nav-icon"></i> Privilèges</h6>

                            <div class="row">
                                <div class="col">
                                    <p>Privileges disponibles</p>

                                    <table class="table table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th>Nom</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($privileges as $privilege)
                                            <tr>
                                                <td>
                                                    @if(check_privilege('privileges.attach'))
                                                        <a href="{{route('privileges.attach', [$privilege->id, $role->code])}}">{{$privilege->name}}</a>
                                                    @else
                                                        {{$privilege->name}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td><em>Aucun privilège</em></td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col">
                                    <p class="text-right">Privilèges attribués</p>

                                    <table class="table table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-right">Nom</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($affected as $privilege)
                                            <tr>
                                                <td class="text-right">
                                                    {{$privilege->name}}
                                                </td>
                                                <td class="text-right">
                                                    @if(check_privilege('privileges.detach'))
                                                        <a href="{{route('privileges.detach', [$privilege->id, $role->code])}}">
                                                            <span class="fa fa-minus fa-fw"></span>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-right"><em>Aucun privilège</em></td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
