<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Asistencia - {{ $estudiante->nombre }} {{ $estudiante->ap_paterno }}</title>
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
        .info-estudiante {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info-estudiante p {
            margin: 5px 0;
        }
        .estadisticas {
            display: table;
            width: 100%;
            margin: 20px 0;
        }
        .estadisticas .stat-box {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .stat-box h3 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .stat-box p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 11px;
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
            background-color: #28a745;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
            font-size: 10px;
        }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-info { background-color: #17a2b8; }
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
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE ASISTENCIA POR ESTUDIANTE</h1>
        <p>Universidad Boliviana de Informática - UBI</p>
        <p>Fecha de generación: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="info-estudiante">
        <p><strong>Estudiante:</strong> {{ $estudiante->nombre }} {{ $estudiante->ap_paterno }} {{ $estudiante->ap_materno }}</p>
        <p><strong>Matrícula:</strong> {{ $estudiante->matricula }}</p>
        <p><strong>CI:</strong> {{ $estudiante->ci }}</p>
        <p><strong>Carrera:</strong> {{ $estudiante->carrera->carrera ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $estudiante->email }}</p>
    </div>

    <div class="estadisticas">
        <div class="stat-box" style="background-color: #d4edda;">
            <h3>{{ $presentes }}</h3>
            <p>PRESENTES</p>
        </div>
        <div class="stat-box" style="background-color: #f8d7da;">
            <h3>{{ $ausentes }}</h3>
            <p>AUSENTES</p>
        </div>
        <div class="stat-box" style="background-color: #fff3cd;">
            <h3>{{ $justificadas }}</h3>
            <p>JUSTIFICADAS</p>
        </div>
        <div class="stat-box" style="background-color: #d1ecf1;">
            <h3>{{ $porcentajeAsistencia }}%</h3>
            <p>% ASISTENCIA</p>
        </div>
    </div>

    @if($asistencias->isEmpty())
        <p style="text-align: center; margin-top: 30px; color: #999;">
            No se encontraron registros de asistencia para este estudiante.
        </p>
    @else
        <h3>Historial de Asistencias ({{ $asistencias->count() }} registros)</h3>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Materia</th>
                    <th>Semestre</th>
                    <th>Estado</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asistencias as $asistencia)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($asistencia->sesion->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $asistencia->sesion->grupo->materia->materia ?? 'N/A' }}</td>
                    <td>{{ $asistencia->sesion->grupo->semestre->semestre ?? 'N/A' }}</td>
                    <td>
                        @if($asistencia->estado_asistencia == 'Presente')
                            <span class="badge badge-success">PRESENTE</span>
                        @elseif($asistencia->estado_asistencia == 'Ausente')
                            <span class="badge badge-danger">AUSENTE</span>
                        @elseif($asistencia->estado_asistencia == 'Justificado')
                            <span class="badge badge-warning">JUSTIFICADO</span>
                        @else
                            <span class="badge badge-info">{{ strtoupper($asistencia->estado_asistencia) }}</span>
                        @endif
                    </td>
                    <td>{{ $asistencia->observacion ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Sistema de Control de Asistencia Universitaria - UBI
    </div>
</body>
</html>
