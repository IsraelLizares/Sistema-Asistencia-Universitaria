@extends('adminlte::page')

@section('title', 'Reporte de Asistencia por Materia')

@section('content_header')
    <h1><i class="fas fa-book"></i> Reporte de Asistencia por Materia</h1>
@stop

@section('content')
<!-- Información de la Materia -->
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Información de la Materia</h3>
        <div class="card-tools">
            <button onclick="window.print()" class="btn btn-sm btn-light">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Materia:</strong> {{ $materia->materia }}</p>
                <p><strong>Código:</strong> {{ $materia->sigla }}</p>
            </div>
            <div class="col-md-6">
                @if($semestre)
                    <p><strong>Semestre:</strong> {{ $semestre->semestre }}</p>
                @endif
                <p><strong>Grupos:</strong> {{ $grupos->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Grupos de la Materia -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Grupos y Estadísticas</h3>
    </div>
    <div class="card-body">
        @if($grupos->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead class="bg-info">
                    <tr>
                        <th>Grupo</th>
                        <th>Semestre</th>
                        <th>Docente</th>
                        <th>Turno</th>
                        <th>Aula</th>
                        <th class="text-center">Sesiones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupos as $grupo)
                    <tr>
                        <td>{{ $grupo->nombre ?? 'Grupo ' . $grupo->id }}</td>
                        <td>{{ $grupo->semestre->semestre ?? 'N/A' }}</td>
                        <td>{{ $grupo->docente->nombre ?? '' }} {{ $grupo->docente->ap_paterno ?? '' }}</td>
                        <td>{{ $grupo->turno->turno ?? 'N/A' }}</td>
                        <td>{{ $grupo->aula->aula ?? 'N/A' }}</td>
                        <td class="text-center">
                            {{ $sesiones->where('id_grupo', $grupo->id)->count() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No hay grupos registrados para esta materia.
        </div>
        @endif
    </div>
</div>

<!-- Sesiones Registradas -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sesiones Registradas</h3>
    </div>
    <div class="card-body">
        @if($sesiones->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead class="bg-secondary">
                    <tr>
                        <th>Fecha</th>
                        <th>Grupo</th>
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
                        <td>{{ $sesion->grupo->nombre ?? 'Grupo ' . $sesion->id_grupo }}</td>
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
                        <th colspan="3" class="text-right">TOTALES:</th>
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
            <i class="fas fa-info-circle"></i> No hay sesiones registradas para esta materia.
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
