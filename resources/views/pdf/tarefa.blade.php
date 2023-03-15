<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        .page-break {
            page-break-after: always;
        }

        .titulo {
            text-align: center;
            width: 100%;
            font-family: sans-serif;
            font-size: 1.5rem;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 20px
        }

        body {
            font-family: sans-serif
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th{
            background: rgb(142, 234, 170)
        }

        th,
        td {
            text-align: center
        }

        .table tbody tr:nth-child(odd){
            background: #fff;
        }
        .table tbody tr:nth-child(even){
            background: #e2e2e2;
        }
    </style>
</head>

<body>
    <div class="titulo">Tarefas</div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tarefa</th>
                <th>Usuario</th>
                <th>Conclusão</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tarefas as $tarefa)
                <tr>
                    <td>{{ $tarefa->id }}</td>
                    <td>{{ $tarefa->tarefa }}</td>
                    <td>{{ $tarefa->usuario->name }}</td>
                    <td>{{ date('d1/m/Y', strtotime($tarefa->data_limite_conclusao)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>
    <h2>Pagina 2</h2>
</body>

</html>
