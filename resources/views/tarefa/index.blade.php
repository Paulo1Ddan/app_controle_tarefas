@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        Tarefas 
                        <div>
                            <a href="{{route('tarefa.create')}}" class="btn btn-primary">Cadastrar</a>
                            <a href="{{route('tarefa.exportacao', ['ext'=>'xlsx'])}}" class="btn btn-primary">XLSX</a>
                            <a href="{{route('tarefa.exportacao', ['ext'=>'csv'])}}" class="btn btn-primary">CSV</a>
                            <a href="{{route('tarefa.exportar')}}" target="_blank" class="btn btn-primary">PDF</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="overflow:auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tarefa</th>
                                        <th scope="col">Dt. Limite</th>
                                        <th scope="col" colspan="2">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tarefas as $tarefa)
                                        <tr>
                                            <th scope="row">{{$tarefa->id}}</th>
                                            <td>{{$tarefa->tarefa}}</td>
                                            <td>{{date("d/m/Y", strtotime($tarefa->data_limite_conclusao))}}</td>
                                            <td><a href="{{ route('tarefa.edit', $tarefa->id) }}">Editar</a></td>
                                            <td>
                                                <form id="delete_{{$tarefa->id}}" action="{{route('tarefa.destroy', ['tarefa' => $tarefa->id])}}" method="post">
                                                    @csrf
                                                    @method("DELETE")
                                                    <a href='#' onclick="document.getElementById('delete_{{$tarefa->id}}').submit()">Excluir</a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
    
                                </tbody>
                            </table>
                        </div>

                        {{$tarefas->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
