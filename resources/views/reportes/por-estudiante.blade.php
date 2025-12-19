@extends('adminlte::page')

@section('title', 'Reporte de Asistencia por Estudiante')

@section('content_header')
    <h1><i class="fas fa-user-graduate"></i> Reporte de Asistencia por Estudiante</h1>
@stop

@section('content')
<!-- Información del Estudiante -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Información del Estudiante</h3>
        <div class="card-tools">
            <button onclick="window.print()" class="btn btn-sm btn-light">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
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
                <h3>{{ $presentes }}</h3>
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
                <h3>{{ $ausentes }}</h3>
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
                <h3>{{ $justificadas }}</h3>
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
                <h3>{{ $porcentajeAsistencia }}%</h3>
                <p>Asistencia</p>
            </div>
            <div class="icon">
                <i class="fas fa-percentage"></i>
            </div>
        </div>
    </div>
</div>

<!-- Detalle de Asistencias -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalle de Asistencias</h3>
    </div>
    <div class="card-body">
        @if($asistencias->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead class="bg-primary">
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
            <i class="fas fa-info-circle"></i> El estudiante no tiene registros de asistencia.
        </div>
        @endif
    </div>
</div>
@stop

@section('css')
<style>
    @media print {
        .btn, .card-tools, .main-sidebar, .main-header, .content-header { display: none !important; }
    }
</style>
@stop
