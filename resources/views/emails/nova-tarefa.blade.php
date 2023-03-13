<x-mail::message>
# {{$tarefa}}

Data limite de conclusão: {{$data_limite_conclusao}}.

<x-mail::button :url="$url">
Ver tarefa
</x-mail::button>

Att,<br>
{{ config('app.name') }}
</x-mail::message>
