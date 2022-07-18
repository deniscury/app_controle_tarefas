@component('mail::message')
# {{$tarefa}}

Data limite de conclusão: {{date('d/m/Y', strtotime($data_limite_conclusao))}}

@component('mail::button', ['url' => $url])
Clique aqui para visualizar a tarefa
@endcomponent

Att,<br>
{{ config('app.name') }}
@endcomponent
