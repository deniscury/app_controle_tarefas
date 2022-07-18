<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{!isset($tarefa->id) ? 'Adicionar' : 'Alterar'}} Tarefa</div>

                <div class="card-body">
                    @if(isset($tarefa->id))
                        <form method="post" action="{{route('tarefa.update', ['tarefa' => $tarefa->id])}}">
                            @csrf
                            @method("PUT")
                    @else
                        <form method="post" action="{{route('tarefa.store')}}">
                            @csrf
                    @endif
                    <form method="POST" action="{{route('tarefa.store')}}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tarefa</label>
                            <input type="text" class="form-control" name="tarefa" value="{{$tarefa->tarefa ?? old('tarefa')}}">
                            {{$errors->has('tarefa')?$errors->first('tarefa'):''}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Data Limite Conclusão</label>
                            <input type="date" class="form-control" name="data_limite_conclusao" value="{{$tarefa->data_limite_conclusao ?? old('data_limite_conclusao')}}">
                            {{$errors->has('data_limite_conclusao')?$errors->first('data_limite_conclusao'):''}}
                        </div>
                        <button type="submit" class="btn btn-primary">{{!isset($tarefa->id) ? 'Cadastrar' : 'Editar'}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>