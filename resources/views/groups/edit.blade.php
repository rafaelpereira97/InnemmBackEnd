@extends('layouts.backend')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>INNEMM - Editar Grupo</h1>
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
                    <h3 class="card-title">Editar Grupo</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="{{route('group.storeEdit', $group->id)}}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nome do grupo</label>
                            <input value="{{$group->name}}" name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Descrição do grupo</label>
                            <input value="{{$group->description}}" name="description" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                        </div>

                        <label>Associar Bombeiros ao Grupo</label>
                        @foreach($bombeiros as $bombeiro)
                            <div class="form-check">
                                <input @if($group->users->contains($bombeiro->id)) checked @endif name="bombeiros[]" value="{{$bombeiro->id}}" type="checkbox" class="form-check-input" id="{{$bombeiro->id}}">
                                <label class="form-check-label" for="{{$bombeiro->id}}">{{$bombeiro->name}}</label>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary float-right">Editar</button>
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
