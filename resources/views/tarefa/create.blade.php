@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Adicionar Tarefa</div>

                    <div class="card-body">
                        <form method="POST"  action="{{route('tarefa.store')}}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tarefa</label>
                                <input type="text" class="form-control" name="tarefa">
                                @if($errors->has('tarefa'))
                                    <p class="text-danger">{{$errors->first('tarefa')}}</p>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Data limite conclusão</label>
                                <input type="date" class="form-control" name="data_limite_conclusao">
                                @if($errors->has('data_limite_conclusao'))
                                    <p class="text-danger">{{$errors->first('data_limite_conclusao')}}</p>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </form>
                        @if(session('msg_success'))
                            <div class="msg-succeess">
                                <p class="text-success">{{session('msg_success')}}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
