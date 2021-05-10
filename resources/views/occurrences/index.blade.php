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
                    <form action="" method="POST">
                        @csrf
                    <div class="form-group">
                        <label for="group">Grupo de Bombeiros</label>
                        <select required id="group" name="group_id" class="form-control">
                            @foreach($groups as $group)
                            <option>{{$group->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ocorrência</label>
                        <input required type="text" class="form-control" id="exampleInputEmail1" placeholder="Título da Ocorrência">
                    </div>
                    <div class="form-group">
                        <label for="auto_message">Mensagem automática</label>
                        <select id="auto_message" name="auto_message" class="form-control">
                            <option selected>Selecionar mensagem automática ...</option>
                            <option>Alerta 1</option>
                            <option>Alerta 1</option>
                            <option>Alerta 1</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Descrição da Ocorrência</label>
                        <textarea required rows="5" class="form-control" id="exampleInputEmail1" placeholder="Faça uma breve descrição da ocorrência, os bombeiros poderão ver esta descrição..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="urgency">Grau de Urgência</label>
                        <select required id="urgency" name="urgency_id" class="form-control">
                            @foreach($urgencies as $urgency)
                                <option>{{$urgency->name}}</option>
                            @endforeach
                        </select>
                    </div>
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
