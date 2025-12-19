<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte General de Asistencias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
        }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-info { background-color: #17a2b8; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE GENERAL DE ASISTENCIAS</h1>
        <p>Universidad Boliviana de Informática - UBI</p>
        <p>Fecha de generación: {{ date('d/m/Y H:i') }}</p>
    </div>

    @if($sesiones->isEmpty())
        <p style="text-align: center; margin-top: 50px; color: #999;">
            No se encontraron registros con los filtros seleccionados.
        </p>
    @else
        <p><strong>Total de sesiones:</strong> {{ $sesiones->count() }}</p>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Materia</th>
                    <th>Semestre</th>
                    <th>Docente</th>
                    <th>Presentes</th>
                    <th>Ausentes</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sesiones as $sesion)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($sesion->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $sesion->grupo->materia->materia ?? 'N/A' }}</td>
                    <td>{{ $sesion->grupo->semestre->semestre ?? 'N/A' }}</td>
                    <td>{{ $sesion->grupo->docente->nombre ?? '' }} {{ $sesion->grupo->docente->ap_paterno ?? '' }}</td>
                    <td style="text-align: center;">{{ $sesion->asistencias->where('estado_asistencia', 'Presente')->count() }}</td>
                    <td style="text-align: center;">{{ $sesion->asistencias->where('estado_asistencia', 'Ausente')->count() }}</td>
                    <td style="text-align: center;">{{ $sesion->asistencias->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 30px;">
            <h3>Resumen General</h3>
            <p><strong>Total Presentes:</strong> {{ $sesiones->sum(function($s) { return $s->asistencias->where('estado_asistencia', 'Presente')->count(); }) }}</p>
            <p><strong>Total Ausentes:</strong> {{ $sesiones->sum(function($s) { return $s->asistencias->where('estado_asistencia', 'Ausente')->count(); }) }}</p>
            <p><strong>Total Justificadas:</strong> {{ $sesiones->sum(function($s) { return $s->asistencias->where('estado_asistencia', 'Justificado')->count(); }) }}</p>
            <p><strong>Total Registros:</strong> {{ $sesiones->sum(function($s) { return $s->asistencias->count(); }) }}</p>
        </div>
    @endif

    <div class="footer">
        Sistema de Control de Asistencia Universitaria - UBI | Página <script type="text/php">
            if (isset($pdf)) {
                $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Arial");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width) / 2;
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>
    </div>
</body>
</html>
