@extends('layouts.backend')

@section('content')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>INNEMM - Dashboard</h1>
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
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Administradores</span>
                                <span class="info-box-number">
                  {{$adminsCount}}
                  <small></small>
                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-exclamation"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Ocorrências a Decorrer</span>
                                <span class="info-box-number">{{$activeOccurrences}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Ocorrências Terminadas</span>
                                <span class="info-box-number">{{$doneOccurrences}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Bombeiros</span>
                                <span class="info-box-number">{{$bombeirosCount}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
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

                                         new mapboxgl.Marker()
                                             .setLngLat([{!! $user->longitude !!},{!! $user->latitude !!}])
                                             .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                                                 .setHTML("<img width='20px' src='http://127.0.0.1:8000/images/avatar.png'><br><h6>Bombeiro {!! $user->name !!}</h6>"))
                                             .addTo(map);

                                     @endforeach

                                     @foreach($occurrences as $occurrence)

                                         @if($occurrence->latitude && $occurrence->longitude != null)
                                             new mapboxgl.Marker()
                                                 .setLngLat([{!! $occurrence->longitude !!},{!! $occurrence->latitude !!}])
                                                 .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                                                     .setHTML("<img width='20px' src='http://127.0.0.1:8000/images/avatar.png'><br><h6>Ocorrência - {!! $occurrence->title !!}</h6>"))
                                                 .addTo(map);
                                         @endif

                                     @endforeach
                                 </script>
                             </div>
                         </div>
                    </div>
                    <div class="col-md-4">
                         <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Ocorrências em Curso</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>Ocorrência</th>
                                        <th>Urgência</th>
                                        <th>Descrição</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($occurrences as $occurrence)
                                    <tr class="linhaOcorrencia" onclick="window.location.href='{{route('occurrence.show',$occurrence)}}'">
                                        <td>{{$occurrence->title}}</td>
                                        @if($occurrence->urgency_id == 1)
                                            <td><span class="badge badge-danger">{{$occurrence->urgency->name}}</span></td>
                                        @elseif($occurrence->urgency_id == 2)
                                            <td><span class="badge badge-warning">{{$occurrence->urgency->name}}</span></td>
                                        @else
                                            <td><span class="badge badge-success">{{$occurrence->urgency->name}}</span></td>
                                        @endif
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">{{$occurrence->description}}</div>
                                        </td>
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
