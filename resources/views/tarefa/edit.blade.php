@extends('layouts.app')

@section('content')
<div class="container">
    @component('tarefa.layouts._components.form_tarefa', array(
        'tarefa' => $tarefa
    ));
    @endcomponent
</div>
@endsection
