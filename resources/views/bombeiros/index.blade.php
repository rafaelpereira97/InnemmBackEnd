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
                    <h3 class="card-title">Listagem de Bombeiros</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <a href="{{route('bombeiro.create')}}" class="btn btn-primary float-right">Novo Bombeiro</a>

                    <table class="table m-0">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Criado em:</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td>
                                    {{$user->created_at}}
                                </td>
                                <td>
                                    <div class="float-right">
                                        <a href="{{route('bombeiro.edit',$user)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                        <a data-bombeiroid="{{$user->id}}" data-toggle="modal" data-target="#deleteBombeiroModal" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="deleteBombeiroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{route('bombeiro.delete')}}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tem a certeza?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Tem a certeza que deseja remover ?
                        <input type="hidden" value="" id="bombeiro_id" name="bombeiro_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Remover</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
