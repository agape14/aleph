<!DOCTYPE html>
<html>
<head>
    <title>Listado de Solicitudes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        table td {
            white-space: nowrap;
            word-wrap: break-word;
        }
        .table-header {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Listado de Solicitudes</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>VIVE CON</th>
                <th>MOTIVOS BECA</th>
                <th>RAZONES MOTIVOS</th>
                <th>PERIODO ACADÉMICO</th>
                <th>REGLAMENTO LEÍDO</th>
                <th>ESTADO SOLICITUD</th>
                <th>ESTUDIANTE TIPO DOCUMENTO</th>
                <th>ESTUDIANTE NRO DOCUMENTO</th>
                <th>ESTUDIANTE APELLIDO PATERNO</th>
                <th>ESTUDIANTE APELLIDO MATERNO</th>
                <th>ESTUDIANTE NOMBRES</th>
                <th>ESTUDIANTE CÓDIGO SIANET</th>
                <th>PROGENITOR 1 NOMBRES</th>
                <th>PROGENITOR 1 APELLIDOS</th>
                <th>PROGENITOR 1 INGRESOS MENSUALES</th>
                <th>PROGENITOR 2 NOMBRES</th>
                <th>PROGENITOR 2 APELLIDOS</th>
                <th>PROGENITOR 2 INGRESOS MENSUALES</th>
                <th>INGRESOS PLANILLA</th>
                <th>INGRESOS HONORARIOS</th>
                <th>INGRESOS PENSIÓN</th>
                <th>INGRESOS ALQUILER</th>
                <th>OTROS INGRESOS</th>
                <th>TOTAL INGRESOS</th>
                <th>GASTOS COLEGIOS</th>
                <th>GASTOS TALLERES</th>
                <th>GASTOS UNIVERSIDAD</th>
                <th>OTROS GASTOS</th>
                <th>TOTAL GASTOS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($solicitudes as $index => $solicitud)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $solicitud['VIVE CON'] }}</td>
                <td>{{ $solicitud['MOTIVOS BECA'] }}</td>
                <td>{{ $solicitud['RAZONES MOTIVOS'] }}</td>
                <td>{{ $solicitud['PERIODO ACADÉMICO'] }}</td>
                <td>{{ $solicitud['REGLAMENTO LEÍDO'] }}</td>
                <td>{{ $solicitud['ESTADO SOLICITUD'] }}</td>
                <td>{{ $solicitud['ESTUDIANTE TIPO DOCUMENTO'] }}</td>
                <td>{{ $solicitud['ESTUDIANTE NRO DOCUMENTO'] }}</td>
                <td>{{ $solicitud['ESTUDIANTE APELLIDO PATERNO'] }}</td>
                <td>{{ $solicitud['ESTUDIANTE APELLIDO MATERNO'] }}</td>
                <td>{{ $solicitud['ESTUDIANTE NOMBRES'] }}</td>
                <td>{{ $solicitud['ESTUDIANTE CÓDIGO SIANET'] }}</td>
                <td>{{ $solicitud['PROGENITOR 1 NOMBRES'] }}</td>
                <td>{{ $solicitud['PROGENITOR 1 APELLIDOS'] }}</td>
                <td>{{ $solicitud['PROGENITOR 1 INGRESOS MENSUALES'] }}</td>
                <td>{{ $solicitud['PROGENITOR 2 NOMBRES'] }}</td>
                <td>{{ $solicitud['PROGENITOR 2 APELLIDOS'] }}</td>
                <td>{{ $solicitud['PROGENITOR 2 INGRESOS MENSUALES'] }}</td>
                <td>{{ $solicitud['INGRESOS PLANILLA'] }}</td>
                <td>{{ $solicitud['INGRESOS HONORARIOS'] }}</td>
                <td>{{ $solicitud['INGRESOS PENSIÓN'] }}</td>
                <td>{{ $solicitud['INGRESOS ALQUILER'] }}</td>
                <td>{{ $solicitud['OTROS INGRESOS'] }}</td>
                <td>{{ $solicitud['TOTAL INGRESOS'] }}</td>
                <td>{{ $solicitud['GASTOS COLEGIOS'] }}</td>
                <td>{{ $solicitud['GASTOS TALLERES'] }}</td>
                <td>{{ $solicitud['GASTOS UNIVERSIDAD'] }}</td>
                <td>{{ $solicitud['OTROS GASTOS'] }}</td>
                <td>{{ $solicitud['TOTAL GASTOS'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
