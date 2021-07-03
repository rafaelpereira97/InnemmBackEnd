@extends('layouts.backend')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>INNEMM - Bombeiros</h1>
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
                    <h3 class="card-title">Editar Bombeiro {{$user->name}}</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <form method="POST" action="{{route('bombeiro.save')}}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nome do Bombeiro</label>
                            <input value="{{$user->name}}" name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Endereço de Email</label>
                            <input value="{{$user->email}}" name="email" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Grupo de Bombeiros</label>
                            @foreach($groups as $group)
                                <div class="form-check">
                                    <input @if($user->groups->contains($group)) checked @endif name="groups[]" value="{{$group->id}}" type="checkbox" class="form-check-input" id="{{$group->id}}">
                                    <label class="form-check-label" for="{{$group->id}}">{{$group->name}}</label>
                                </div>
                            @endforeach
                        </div>

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
