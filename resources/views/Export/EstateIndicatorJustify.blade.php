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
            <th>Código Dependencia</th>
            <th>Dependencia</th>
            <th>Validez</th>
            <th>Código Indicador</th>
            <th>Nombre Indicador</th>
            <th>Perspectiva</th>
            <th>Nombre Perspectiva</th>
            <th>Objetivo Estrategia</th>
            <th>Nombre Estrategia</th>
            <th>Mes</th>
            <th>Meta</th>
            <th>Ejecución Metas</th>
            <th>Justificación Estado Indicador</th>
            <th>Justificación Estado Presupuesto</th>
            <th>Observación Control</th>
            <th>Asesor</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($followupComplete as $item)
            <tr>
                <td data-format="0" class="text-right">{{ $item['cod_dep'] }}</td>
                <td data-format="text" class="text-left">{{ $item['Dependence'] }}</td>
                <td data-format="text" class="text-center">{{ $item['validity'] }}</td>
                <td data-format="0" class="text-right">{{ $item['cod_indicator'] }}</td>
                <td data-format="text" class="text-left">{{ $item['name_indicator'] }}</td>
                <td data-format="text" class="text-center">{{ $item['perspective'] }}</td>
                <td data-format="text" class="text-center">{{ $item['name_perspective'] }}</td>
                <td data-format="text" class="text-left">{{ $item['objective_strategy'] }}</td>
                <td data-format="text" class="text-left">{{ $item['name_strategy'] }}</td>
                <td data-format="text" class="text-center">{{ $item['month'] }}</td>
                <td data-format="0" class="text-right">{{ $item['goal'] }}</td>
                <td data-format="0" class="text-right">{{ $item['execution_goals'] }}</td>
                <td data-format="text" class="text-left">{{ $item['justify_estate_indicator'] }}</td>
                <td data-format="text" class="text-left">{{ $item['justify_estate_money'] }}</td>
                <td data-format="text" class="text-left">{{ $item['observation_control'] }}</td>
                <td data-format="text" class="text-left">{{ $item['assesor'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div>
    <h1>Seguimiento Incompleto de la Vigencia</h1>
    <table>
        <thead>
        <tr>
            <th>Código Dependencia</th>
            <th>Dependencia</th>
            <th>Validez</th>
            <th>Código Indicador</th>
            <th>Nombre Indicador</th>
            <th>Perspectiva</th>
            <th>Nombre Perspectiva</th>
            <th>Objetivo Estrategia</th>
            <th>Nombre Estrategia</th>
            <th>Mes</th>
            <th>Meta</th>
            <th>Ejecución Metas</th>
            <th>Justificación Estado Indicador</th>
            <th>Justificación Estado Presupuesto</th>
            <th>Observación Control</th>
            <th>Asesor</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($followupIncomplete as $item)
            <tr>
                <td data-format="0" class="text-right">{{ $item['cod_dep'] }}</td>
                <td data-format="text" class="text-left">{{ $item['Dependence'] }}</td>
                <td data-format="text" class="text-center">{{ $item['validity'] }}</td>
                <td data-format="0" class="text-right">{{ $item['cod_indicator'] }}</td>
                <td data-format="text" class="text-left">{{ $item['name_indicator'] }}</td>
                <td data-format="text" class="text-center">{{ $item['perspective'] }}</td>
                <td data-format="text" class="text-center">{{ $item['name_perspective'] }}</td>
                <td data-format="text" class="text-left">{{ $item['objective_strategy'] }}</td>
                <td data-format="text" class="text-left">{{ $item['name_strategy'] }}</td>
                <td data-format="text" class="text-center">{{ $item['month'] }}</td>
                <td data-format="0" class="text-right">{{ $item['goal'] }}</td>
                <td data-format="0" class="text-right">{{ $item['execution_goals'] }}</td>
                <td data-format="text" class="text-left">{{ $item['justify_estate_indicator'] }}</td>
                <td data-format="text" class="text-left">{{ $item['justify_estate_money'] }}</td>
                <td data-format="text" class="text-left">{{ $item['observation_control'] }}</td>
                <td data-format="text" class="text-left">{{ $item['assesor'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div>
    <h1>Seguimiento Incompleto de la Vigencia Sin Indicador</h1>
    <table>
        <thead>
        <tr>
            <th>Código Dependencia</th>
            <th>Dependencia</th>
            <th>Validez</th>
            <th>Justificación Estado Indicador</th>
            <th>Justificación Estado Presupuesto</th>
            <th>Observación Control</th>
            <th>Asesor</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($followOutIndicators as $item)
            <tr>
                <td data-format="0" class="text-right">{{ $item['cod_dep'] }}</td>
                <td data-format="text" class="text-left">{{ $item['Dependence'] }}</td>
                <td data-format="text" class="text-center">{{ $item['validity'] }}</td>
                <td data-format="text" class="text-left">{{ $item['justify_estate_indicator'] }}</td>
                <td data-format="text" class="text-left">{{ $item['justify_estate_money'] }}</td>
                <td data-format="text" class="text-left">{{ $item['observation_control'] }}</td>
                <td data-format="text" class="text-left">{{ $item['assesor'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
