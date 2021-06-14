@extends('layouts.backend')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>INNEMM - Ver Ocorrência</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Blank Page</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Mapa de Bombeiros</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div id="map" style="width: 100%; height: 600px;"></div>
                            <script>
                                mapboxgl.accessToken = 'pk.eyJ1IjoicmFmYWVscGVyZWlyYTk3IiwiYSI6ImNrb2l1OWRoMTBvb3gyeHJtMjc5bHQzcjMifQ.a9JVwy1esI237WyBi2uQUQ';
                                var map = new mapboxgl.Map({
                                    container: 'map',
                                    style: 'mapbox://styles/mapbox/streets-v11',
                                    zoom: 3 // starting zoom
                                });
                                map.addControl(
                                    new mapboxgl.GeolocateControl({
                                        positionOptions: {
                                            enableHighAccuracy: true
                                        },
                                        trackUserLocation: true
                                    })
                                );
                                map.addControl(new mapboxgl.FullscreenControl());



                                var formmatedPositions = [];


                                console.log(formmatedPositions)









                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Bombeiros desta Ocorrência</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>Bombeiro</th>
                                        <th>Estado</th>
                                        <th>Vista</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr data-bombeiroID="{{$user->id}}" data-ocorrenciaID="{{$occurrence->id}}" class="linhaOcorrencia linhaBombeiro">
                                            <td>{{$user->name}}</td>
                                            @switch($user->pivot->status)
                                                @case(0)
                                                <td>Pendente</td>
                                                @break

                                                @case(1)
                                                <td>Aceite</td>
                                                @break

                                                @case(2)
                                                <td>Recusada</td>
                                                @break

                                                @default
                                                Default case...
                                            @endswitch

                                            @if($user->pivot->opened == 1)
                                                <td><span class="badge badge-success">Aberta</span></td>
                                            @else
                                                <td><span class="badge badge-light">Por Abrir</span></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                        <!-- /.card-body -->

                        <!-- /.card-footer -->
                    </div>
                </div>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->

@endsection
<link href="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.js"></script>
<script src='https://unpkg.com/@turf/turf@6.3.0/turf.min.js'></script>
