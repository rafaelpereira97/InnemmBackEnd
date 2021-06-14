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

                                @foreach($users as $user)
                                        @if(count($user->getLocationsByOccurrence($occurrence)) > 0)
                                        var positions = {!! json_encode($user->getLocationsByOccurrence($occurrence)) !!};

                                        var formmatedPositions = [];

                                            for (i = 0; i < positions.length; i++) {
                                                formmatedPositions.push([parseFloat(positions[i].long),parseFloat(positions[i].lat)])
                                            }

                                console.log(formmatedPositions)

                                var linestring = turf.lineString(positions);

                                map.on('load', function () {
                                    map.addSource('route', {
                                        'type': 'geojson',
                                        'data': {
                                            'type': 'Feature',
                                            'properties': {},
                                            'geometry': {
                                                'type': 'LineString',
                                                'coordinates': formmatedPositions
                                            }
                                        }
                                    });
                                    map.addLayer({
                                        'id': 'route',
                                        'type': 'line',
                                        'source': 'route',
                                        'layout': {
                                            'line-join': 'round',
                                            'line-cap': 'round'
                                        },
                                        'paint': {
                                            'line-color': '#888',
                                            'line-width': 8
                                        }
                                    });
                                });


                                @endif

                                new mapboxgl.Marker()
                                    .setLngLat([{!! $user->longitude !!},{!! $user->latitude !!}])
                                    .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                                        .setHTML("<img width='20px' src='http://127.0.0.1:8000/images/avatar.png'><br><h6>Bombeiro - {!! $user->name !!}</h6>"))
                                    .addTo(map);

                                @endforeach

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
                                        <tr>
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
