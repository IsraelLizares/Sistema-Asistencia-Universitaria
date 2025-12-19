@extends('adminlte::page')

@section('title', 'Reporte General de Asistencias')

@section('content_header')
    <h1><i class="fas fa-list"></i> Reporte General de Asistencias</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sesiones Registradas</h3>
        <div class="card-tools">
            <button onclick="window.print()" class="btn btn-sm btn-primary">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
    </div>
    <div class="card-body">
        @if($sesiones->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead class="bg-primary">
                    <tr>
                        <th>Fecha</th>
                        <th>Materia</th>
                        <th>Semestre</th>
                        <th>Docente</th>
                        <th>Tema</th>
                        <th class="text-center">Presentes</th>
                        <th class="text-center">Ausentes</th>
                        <th class="text-center">Justificados</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sesiones as $sesion)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($sesion->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $sesion->grupo->materia->materia ?? 'N/A' }}</td>
                        <td>{{ $sesion->grupo->semestre->semestre ?? 'N/A' }}</td>
                        <td>{{ $sesion->grupo->docente->nombre ?? '' }} {{ $sesion->grupo->docente->ap_paterno ?? '' }}</td>
                        <td>{{ $sesion->tema ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge badge-success">
                                {{ $sesion->asistencias->where('estado_asistencia', 'presente')->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-danger">
                                {{ $sesion->asistencias->where('estado_asistencia', 'ausente')->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-warning">
                                {{ $sesion->asistencias->where('estado_asistencia', 'justificado')->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <strong>{{ $sesion->asistencias->count() }}</strong>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-light">
                        <th colspan="5" class="text-right">TOTALES:</th>
                        <th class="text-center">
                            <span class="badge badge-success">
                                {{ $sesiones->sum(function($s) { return $s->asistencias->where('estado_asistencia', 'presente')->count(); }) }}
                            </span>
                        </th>
                        <th class="text-center">
                            <span class="badge badge-danger">
                                {{ $sesiones->sum(function($s) { return $s->asistencias->where('estado_asistencia', 'ausente')->count(); }) }}
                            </span>
                        </th>
                        <th class="text-center">
                            <span class="badge badge-warning">
                                {{ $sesiones->sum(function($s) { return $s->asistencias->where('estado_asistencia', 'justificado')->count(); }) }}
                            </span>
                        </th>
                        <th class="text-center">
                            <strong>{{ $sesiones->sum(function($s) { return $s->asistencias->count(); }) }}</strong>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No se encontraron registros con los filtros aplicados.
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
