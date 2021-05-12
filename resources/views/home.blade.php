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
                                <span class="info-box-text">CPU Traffic</span>
                                <span class="info-box-number">
                  10
                  <small>%</small>
                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Likes</span>
                                <span class="info-box-number">41,410</span>
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
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Sales</span>
                                <span class="info-box-number">760</span>
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
                                <span class="info-box-text">New Members</span>
                                <span class="info-box-number">2,000</span>
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
                                     @foreach($users as $user)

                                     var marker1 = new mapboxgl.Marker()
                                         .setLngLat([{!! $user->longitude !!},{!! $user->latitude !!}])
                                         .addTo(map);

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
                                        <th>Order ID</th>
                                        <th>Item</th>
                                        <th>Status</th>
                                        <th>Popularity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($occurrences as $occurrence)
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                        <td>{{$occurrence->title}}</td>
                                        @if($occurrence->urgency_id == 1)
                                            <td><span class="badge badge-danger">{{$occurrence->urgency->name}}</span></td>
                                        @elseif($occurrence->urgency_id == 2)
                                            <td><span class="badge badge-warning">{{$occurrence->urgency->name}}</span></td>
                                        @else
                                            <td><span class="badge badge-success">{{$occurrence->urgency->name}}</span></td>
                                        @endif
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $occurrences->links() }}
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                        </div>
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
