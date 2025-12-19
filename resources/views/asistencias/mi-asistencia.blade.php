@extends('adminlte::page')

@section('title', 'Mi Asistencia')

@section('content_header')
    <h1><i class="fas fa-user-graduate"></i> Mi Historial de Asistencia</h1>
@stop

@section('content')
<!-- Información del Estudiante -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Información Personal</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nombre Completo:</strong> {{ $estudiante->nombre }} {{ $estudiante->ap_paterno }} {{ $estudiante->ap_materno }}</p>
                <p><strong>Matrícula:</strong> {{ $estudiante->matricula }}</p>
                <p><strong>CI:</strong> {{ $estudiante->ci }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Carrera:</strong> {{ $estudiante->carrera->nombre_carrera ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $estudiante->email ?? 'N/A' }}</p>
                <p><strong>Teléfono:</strong> {{ $estudiante->telefono ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas -->
<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $asistencias->where('estado_asistencia', 'presente')->count() }}</h3>
                <p>Presentes</p>
            </div>
            <div class="icon">
                <i class="fas fa-check"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $asistencias->where('estado_asistencia', 'ausente')->count() }}</h3>
                <p>Ausentes</p>
            </div>
            <div class="icon">
                <i class="fas fa-times"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $asistencias->where('estado_asistencia', 'justificado')->count() }}</h3>
                <p>Justificadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                @php
                    $total = $asistencias->count();
                    $presentes = $asistencias->where('estado_asistencia', 'presente')->count();
                    $porcentaje = $total > 0 ? round(($presentes / $total) * 100, 1) : 0;
                @endphp
                <h3>{{ $porcentaje }}%</h3>
                <p>Asistencia</p>
            </div>
            <div class="icon">
                <i class="fas fa-percentage"></i>
            </div>
        </div>
    </div>
</div>

<!-- Historial de Asistencias -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Historial Completo de Asistencias</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
    </div>
    <div class="card-body">
        @if($asistencias->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm" id="tableAsistencias">
                <thead class="bg-primary">
                    <tr>
                        <th>Fecha</th>
                        <th>Materia</th>
                        <th>Semestre</th>
                        <th>Tema</th>
                        <th class="text-center">Estado</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asistencias as $asistencia)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($asistencia->sesion->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $asistencia->sesion->grupo->materia->materia ?? 'N/A' }}</td>
                        <td>{{ $asistencia->sesion->grupo->semestre->semestre ?? 'N/A' }}</td>
                        <td>{{ $asistencia->sesion->tema ?? '-' }}</td>
                        <td class="text-center">
                            @if($asistencia->estado_asistencia == 'presente')
                                <span class="badge badge-success">Presente</span>
                            @elseif($asistencia->estado_asistencia == 'ausente')
                                <span class="badge badge-danger">Ausente</span>
                            @elseif($asistencia->estado_asistencia == 'justificado')
                                <span class="badge badge-warning">Justificado</span>
                            @elseif($asistencia->estado_asistencia == 'tardanza')
                                <span class="badge badge-info">Tardanza</span>
                            @endif
                        </td>
                        <td>{{ $asistencia->observacion ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Aún no tienes registros de asistencia.
        </div>
        @endif
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap4.min.css">
<style>
    @media print {
        .btn, .card-tools, .main-sidebar, .main-header, .content-header { display: none !important; }
    }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Inicializar DataTable
    $('#tableAsistencias').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        order: [[0, 'desc']], // Ordenar por fecha descendente
        pageLength: 25,
        responsive: true
    });
});
</script>
@stop
