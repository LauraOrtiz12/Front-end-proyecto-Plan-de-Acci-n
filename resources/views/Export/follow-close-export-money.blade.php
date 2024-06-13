<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Custom styles */
        .bgcolor-lightgrey {
            background-color: lightgrey;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .valign-middle {
            vertical-align: middle;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div style="font-family: arial; width: 100%">
    <h2>Indicadores Presupuestales</h2>
    <table>
        <thead style="background-color: #9b9b9b; color:white;">
        <tr>
            <th>Código Regional</th>
            <th>Dependencia Control / Regional</th>
            <th>Código Dependencia</th>
            <th>Dependencia</th>
            <th>Vigencia</th>
            <th>Código SIIF</th>
            <th>Código de Proyecto</th>
            <th>Proyecto</th>
            <th>Apertura Presupuestal</th>
            <th>Comprometido</th>
            <th>Pago</th>
            <th>Porcentaje Comprometido</th>
            <th>Ejecución</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($money as $m)
            <tr>
                <td>{{$m['cod_reg']}}</td>
                <td>{{$m['cod_control']}}</td>
                <td>{{$m['cod_dep']}}</td>
                <td>{{$m['dependence']}}</td>
                <td>{{$m['validity']}}</td>
                <td>{{$m['siif']}}</td>
                <td>{{$m['project_id']}}</td>
                <td>{{$m['project']}}</td>
                <td>{{ '$ ' .number_format($m['open_money'])}}</td>
                <td>{{'$ ' . number_format($m['commitment'])}}</td>
                <td>{{ '$ ' . number_format($m['payments'])}}</td>
                <td>{{ number_format($m['commitment_percentage'])}}</td>
                <td>{{number_format($m['payment_execution'], 2)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div>{{date('Y-m-d H:m:s')}}</div>
</body>
</html>
