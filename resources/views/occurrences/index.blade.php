@extends('layouts.backend')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>INNEMM - Criação de Ocorrência</h1>
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
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Criar Ocorrência</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{route('occurrence.store')}}" method="POST">
                        @csrf
                    <div class="form-group">
                        <label for="group">Grupo de Bombeiros</label>
                        <select required id="group" name="group_id" class="form-control">
                            <option disabled selected>Selecionar Grupo ...</option>
                            @foreach($groups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ocorrência</label>
                        <input name="occurrence" required type="text" class="form-control" id="exampleInputEmail1" placeholder="Título da Ocorrência">
                    </div>
                    <div class="form-group">
                        <label for="auto_message">Mensagem automática</label>
                        <select style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;" id="auto_message" class="form-control">
                            <option disabled selected>Selecionar mensagem automática ...</option>
                        </select>
                        <br>
                        <div class="spinner-border" style="display: none;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Descrição da Ocorrência</label>
                        <textarea name="desc_occurrence" required rows="5" class="form-control" id="desc_occurrence" placeholder="Faça uma breve descrição da ocorrência, os bombeiros poderão ver esta descrição..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="urgency">Grau de Urgência</label>
                        <select required id="urgency" name="urgency_id" class="form-control">
                            @foreach($urgencies as $urgency)
                                <option value="{{$urgency->id}}">{{$urgency->name}}</option>
                            @endforeach
                        </select>
                    </div>
                        <div class="form-group">
                            <label for="urgency">Local da Ocorrência</label>
                            <input name="coordinates" required type="text" class="form-control" id="coordinates" placeholder="Coordenadas da Ocorrência">
                        </div>
                    <div style="height: 300px">
                        <div id="map" style="width: 60%; height: 300px;"></div>
                        <script>
                            mapboxgl.accessToken = 'pk.eyJ1IjoicmFmYWVscGVyZWlyYTk3IiwiYSI6ImNrb2l1OWRoMTBvb3gyeHJtMjc5bHQzcjMifQ.a9JVwy1esI237WyBi2uQUQ';
                            var map = new mapboxgl.Map({
                                container: 'map',
                                style: 'mapbox://styles/mapbox/streets-v11',
                                zoom: 3 // starting zoom
                            });
                            map.on('style.load', function() {
                                map.on('click', function(e) {
                                    var coordinates = e.lngLat;
                                    $("#coordinates").val(coordinates.lat+","+coordinates.lng)
                                    new mapboxgl.Popup()
                                        .setLngLat(coordinates)
                                        .setHTML('<b>LOCAL DA OCORRÊNCIA</b>')
                                        .addTo(map);
                                });
                            });
                            map.addControl(
                                new mapboxgl.GeolocateControl({
                                    positionOptions: {
                                        enableHighAccuracy: true
                                    },
                                    trackUserLocation: true
                                })
                            );
                        </script>
                    </div>
                        <br>
                    <button type="submit" class="btn btn-primary">Criar Ocorrência</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
<link href="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.js"></script>
