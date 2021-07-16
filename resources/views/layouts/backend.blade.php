<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GOS') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">

    <link rel="stylesheet" href="{{asset('dist/css/custom.css')}}">


    <style>
        .content-wrapper{
            height: initial;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->


            <!-- Messages Dropdown Menu -->

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="../../index3.html" class="brand-link">
            <img src="{{url('/images/iconInnemm.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">GOS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{url('/images/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
                </div>
            </div>



            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{route('home')}}" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('occurrence.index')}}" class="nav-link">
                            <i class="far fa-plus nav-icon"></i>
                            <p>Criar Ocorrência</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('group.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Grupos
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('status.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Estados
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('message.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>
                                Mensagens Automáticas
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Definições
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                            <li class="nav-item">
                                <a href="{{route('bombeiro.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Bombeiros</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    @yield('content')

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.1.0
        </div>
        <strong>Copyright &copy; 2021 <a href="#">GOS</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
{{--<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>

</body>
</html>

<style>
    .firemanIcon {
        background-image: url('http://127.0.0.1:8000/images/avatar.png');
        background-size: cover;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
    }
</style>

<script>
    $("#group").on('change',function (e){
        var group_id = e.target.value;
        $('#auto_message').empty();
        $('#auto_message').hide();
        $('.spinner-border').show();

        $('#auto_message').append(`<option disabled selected>
                                       ${'Selecionar mensagem automática ...'}
                                  </option>`);
        $.get( '{{route('occurence.getAutoMessages')}}/'+group_id, function( data ) {
            $('#auto_message').show();
            $('.spinner-border').hide();
            $(data).each( function( index, message ){
                $('#auto_message').append(`<option value="${message.message}">
                                       ${message.message}
                                  </option>`);
            });
        });
    });


    $("#auto_message").on('change',function (e){
        $("#desc_occurrence").val($(this).val())
    })


    var firemanMarker
    $(".linhaBombeiro").on('click',function (e){
        console.log(firemanMarker)
        if(firemanMarker!=undefined)
            firemanMarker.remove()


        const bombeiro_id = $(this).attr("data-bombeiroID");
        const ocorrencia_id = $(this).attr("data-ocorrenciaID");

        $.get( "{{route('occurrence.getUserLocations')}}"+'/'+bombeiro_id+'/'+ocorrencia_id, function( data ) {

            if(map.getLayer('route')){
                map.removeLayer('route')
            }

            if(map.getSource('route')){
                map.removeSource('route')
            }

            var lastItem = data.pop();

            var firemanIcon = document.createElement('div');
            firemanIcon.className = 'firemanIcon';
            firemanMarker =  new mapboxgl.Marker(firemanIcon)
                .setLngLat(lastItem)
                .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                    .setHTML("<h6>Bombeiro</h6>"))
                .addTo(map);

            map.flyTo({
                center: [
                    lastItem[0],
                    lastItem[1]
                ],
                zoom: 12,
                essential: true // this animation is considered essential with respect to prefers-reduced-motion
            });

            map.addSource('route', {
                'type': 'geojson',
                'data': {
                    'type': 'Feature',
                    'properties': {},
                    'geometry': {
                        'type': 'LineString',
                        'coordinates': data
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
                    'line-color': '#4167e5',
                    'line-width': 5
                }
            });
            console.log(data)
        });
    });



    $('#deleteModal').on('shown.bs.modal', function (e) {
        let group_id = $(e.relatedTarget).attr('data-groupid');
        $("#group_id").val(group_id)
    })

    $('#deleteBombeiroModal').on('shown.bs.modal', function (e) {
        let bombeiro_id = $(e.relatedTarget).attr('data-bombeiroid');
        $("#bombeiro_id").val(bombeiro_id)
    })

</script>
