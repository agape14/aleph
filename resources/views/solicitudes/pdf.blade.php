<!DOCTYPE html>
<html>
<head>
    <title>Listado de Solicitudes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Listado de Solicitudes</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>DNI Estudiante</th>
                <th>Nombre Estudiante</th>
                <th>Apellido Estudiante</th>
                <th>Progenitores</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($solicitudes as $solicitud)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $solicitud->estudiante->nro_documento }}</td>
                <td>{{ $solicitud->estudiante->nombres }}</td>
                <td>{{ $solicitud->estudiante->apepaterno }} {{ $solicitud->estudiante->apematerno }}</td>
                <td>{{ $solicitud->progenitores->pluck('nombres')->implode(', ') }}</td>
                <td>{{ ucfirst($solicitud->estado_solicitud) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
