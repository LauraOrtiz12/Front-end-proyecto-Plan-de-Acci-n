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
<div>
    <h1>Seguimiento de la Vigencia</h1>
    <table>
        <thead>
        <tr>
            <th>Código Regional</th>
            <th>Dependencia Control / Regional</th>
            <th>Código Dependencia</th>
            <th>Dependencia</th>
            <th>Vigencia</th>
            <th>Código Indicador</th>
            <th>Nombre Indicador</th>
            <th>Mes</th>
            <th>Meta</th>
            <th>Ejecución</th>
            <th>Porcentaje Ejecución</th>
            <th>Porcentaje Esperado</th>
            <th>Justificación de Indicadores</th>
            <th>Justificación de Presupuesto</th>
            <th>Observación Control</th>
            <th>Nombre Perspectiva</th>
            <th>Objetivo Estrategico</th>
            <th>Iniciativa Estratégica</th>
            <th>Fecha Inicial</th>
            <th>Fecha Final</th>
            <th>Recurso Físico</th>
            <th>Recurso Técnico</th>
            <th>Recurso Humano</th>
            <th>Responsable de Indicador</th>
            <th>Cargo Responsable Indicador</th>
            <th>Asesor</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($followupComplete as $item)
            <tr>
                <td data-format="0" class="text-right">{{ $item['cod_reg'] }}</td>
                <td data-format="0" class="text-right">{{ $item['cod_control'] }}</td>
                <td data-format="0" class="text-right">{{ $item['cod_dep'] }}</td>
                <td data-format="text" class="text-left">{{ $item['Dependence'] }}</td>
                <td data-format="0" class="text-center">{{ " ".$item['validity'] }}</td>
                <td data-format="0" class="text-right">{{ $item['cod_indicator'] }}</td>
                <td data-format="text" class="text-left">{{ $item['name_indicator'] }}</td>
                <td data-format="text" class="text-left">{{ $item['month'] }}</td>
                <td data-format="0" class="text-right">{{ $item['goal'] }}</td>
                <td data-format="0.00" class="text-right">{{ $item['execution_goals'] }}</td>
                <td data-format="0.00" class="text-right">{{ $item['per'] }}</td>
                <td data-format="0.00" class="text-center">{{ $item['expected_goal'] }}</td>
                <td data-format="text" class="text-left">{{ $item['justify_estate_indicator'] }}</td>
                <td data-format="text" class="text-left">{{ $item['justify_estate_money'] }}</td>
                <td data-format="text" class="text-left">{{ $item['observation_control'] }}</td>
                <td data-format="text" class="text-center">{{ $item['name_perspective'] }}</td>
                <td data-format="text" class="text-left">{{ $item['objective_strategy'] }}</td>
                <td data-format="text" class="text-left">{{ $item['name_strategy'] }}</td>
                <td data-format="text" class="text-center">{{ $item['start_date'] }}</td>
                <td data-format="text" class="text-center">{{ $item['end_date'] }}</td>
                <td data-format="text" class="text-center">{{ $item['physical_recursion'] }}</td>
                <td data-format="text" class="text-center">{{ $item['technical_recursion'] }}</td>
                <td data-format="text" class="text-center">{{ $item['human_resource'] }}</td>
                <td data-format="text" class="text-center">{{ $item['responsible_indicator'] }}</td>
                <td data-format="text" class="text-center">{{ $item['post_responsible_indicator'] }}</td>


                <td data-format="text" class="text-left">{{ $item['assesor'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
