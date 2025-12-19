<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Carreras</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 15px;
        }

        .header img {
            height: 80px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 24px;
        }

        .fecha {
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        th {
            background-color: #2c3e50 !important;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #7f8c8d;
            font-size: 11px;
        }

        .total-count {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- ENCABEZADO CON LOGO -->
    <div class="header">
        <img src="{{ public_path('img/logo.png') }}" alt="Logo Empresa">
        <h1>LISTA DE CARRERAS</h1>
    </div>
    <!-- TABLA DE PRODUCTOS -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->categoria ?? 'Sin categoría' }}</td>
                    <td>{{ $p->codigo_barras ?: '-' }}</td>
                    <td class="text-right">${{ number_format($p->precio_venta, 2) }}</td>
                    <td class="text-right">{{ number_format($p->cantidad_stock) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        <em>No se encontraron productos activos.</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- TOTAL DE PRODUCTOS -->
    <div class="total-count">
        Total de productos activos: {{ $productos->count() }}
    </div>
    <!-- PIE DE PÁGINA -->
    <div class="footer">
        Reporte generado automáticamente por el sistema •
        {{ config('app.name') }} •
        {{ now()->format('d/m/Y H:i') }}
    </div>
</body>

</html>
