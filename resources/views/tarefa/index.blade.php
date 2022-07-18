@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            Tarefas
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{route('tarefa.create')}}" class="mr-3">Novo</a>
                            <a href="{{route('tarefa.exportar', array('ext' => 'xlsx'))}}" class="mr-3">XLSX</a>
                            <a href="{{route('tarefa.exportar', array('ext' => 'csv'))}}" class="mr-3">CSV</a>
                            <a href="{{route('tarefa.exportar', array('ext' => 'pdf'))}}" class="mr-3">PDF</a>
                            <a href="{{route('tarefa.exportar', array('ext' => 'dompdf'))}}" target="_blank" class="mr-3">DOM PDF</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tarefa</th>
                                <th scope="col">Data Limite de Conclusão</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tarefas as $tarefa)
                                <tr>
                                    <td>{{$tarefa->id}}</td>
                                    <td>{{$tarefa->tarefa}}</td>
                                    <td>{{date('d/m/Y', strtotime($tarefa->data_limite_conclusao))}}</td>
                                    <td><a href="{{route('tarefa.edit', array('tarefa' => $tarefa->id))}}" class="btn btn-success">Editar</a></td>
                                    <td>
                                        <form action="{{route('tarefa.destroy', array('tarefa' => $tarefa->id))}}" id="form_{{$tarefa->id}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <a href="#" class="btn btn-success" onclick="getElementById('form_{{$tarefa->id}}').submit();">Excluir</a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="{{$tarefas->previousPageUrl()}}">Voltar</a></li>
                            @for($i = 1; $i <= $tarefas->lastPage(); $i++)
                                <li class="page-item {{$tarefas->currentPage() == $i? 'active': ''}}">
                                    <a class="page-link" href="{{$tarefas->url($i)}}">{{$i}}</a>
                                </li>
                            @endfor
                            <li class="page-item"><a class="page-link" href="{{$tarefas->nextPageUrl()}}">Avançar</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
