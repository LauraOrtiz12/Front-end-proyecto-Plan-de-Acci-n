<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte De Seguimiento Abierto</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100 p-8">
<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
        <thead>
        <tr class="bg-gray-100 border-b">
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Codigo Regional</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Codigo Dependencia</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Dependencia</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Dependencia Control</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Justificación Indicadores de Gestión</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Justificación Indicadores de Presupuesto</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Observación</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Responsable de Dependencia</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Responsable de Control</th>
        </tr>
        </thead>
        <tbody>
        @foreach($props['follow'] as $follow)
            <tr class="border-b">
                <td class="px-4 py-2 text-sm text-gray-700">{{$follow->getEstateOnly->cod_reg}}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{$follow->getEstateOnly->cod_dep}}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{$follow->getEstateOnly->dependence}}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{$follow->getEstateOnly->control}}</td>
                <td class="px-4 py-2 text-sm text-gray-700">
                    {{$follow->justify_estate_indicator != '-' ? $follow->justify_estate_indicator: 'Sin Justificación'}}
                </td>
                <td class="px-4 py-2 text-sm text-gray-700">
                    {{$follow->justify_estate_money != '-' ? $follow->justify_estate_money : 'Sin Justificación'}}
                </td>
                <td class="px-4 py-2 text-sm text-gray-700">
                    {{$follow->observation_control == '' ? 'Sin Observación' : $follow->observation_control}}
                </td>
                <td class="px-4 py-2 text-sm text-gray-700">{{$follow->getEstateOnly->getResponsible->name}} / {{$follow->getEstateOnly->getResponsible->email}}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{$follow->getEstateOnly->getAdviser->name}} / {{$follow->getEstateOnly->getAdviser->email}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
