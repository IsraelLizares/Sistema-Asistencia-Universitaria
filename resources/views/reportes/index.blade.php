@extends('adminlte::page')

@section('title', 'Reportes de Asistencia')

@section('content_header')
    <h1><i class="fas fa-chart-bar"></i> Reportes de Asistencia</h1>
@stop

@section('content')
<div class="container-fluid">

    <!-- Tarjetas de opciones de reportes -->
    <div class="row">
        <!-- Reporte General -->
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list"></i> Reporte General</h3>
                </div>
                <div class="card-body">
                    <p>Consulta todas las sesiones y asistencias registradas con filtros por fecha, materia y semestre.</p>
                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalReporteGeneral">
                        <i class="fas fa-search"></i> Generar Reporte
                    </button>
                </div>
            </div>
        </div>

        <!-- Reporte por Estudiante -->
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-graduate"></i> Reporte por Estudiante</h3>
                </div>
                <div class="card-body">
                    <p>Consulta el historial completo de asistencias de un estudiante específico.</p>
                    <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modalReporteEstudiante">
                        <i class="fas fa-search"></i> Generar Reporte
                    </button>
                </div>
            </div>
        </div>

        <!-- Reporte por Materia -->
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-book"></i> Reporte por Materia</h3>
                </div>
                <div class="card-body">
                    <p>Consulta las estadísticas de asistencia de una materia específica.</p>
                    <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modalReporteMateria">
                        <i class="fas fa-search"></i> Generar Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row mt-4">
        <!-- Gráfico de Asistencias de los últimos 7 días -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line"></i> Asistencias de los Últimos 7 Días</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartAsistencias7Dias" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico Top 10 Estudiantes con más faltas -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger">
                    <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Top 10 Faltas</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartTopFaltas" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Reporte General -->
<div class="modal fade" id="modalReporteGeneral" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Filtros - Reporte General</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('reportes.general') }}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Fecha Fin</label>
                        <input type="date" name="fecha_fin" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Materia</label>
                        <select name="id_materia" class="form-control select2">
                            <option value="">Todas</option>
                            @if(isset($materias))
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}">{{ $materia->nombre_materia }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semestre</label>
                        <select name="id_semestre" class="form-control select2">
                            <option value="">Todos</option>
                            @if(isset($semestres))
                                @foreach($semestres as $semestre)
                                    <option value="{{ $semestre->id }}">{{ $semestre->nombre_semestre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </button>
                    <button type="submit" formaction="{{ route('reportes.pdf.general') }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reporte por Estudiante -->
<div class="modal fade" id="modalReporteEstudiante" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Filtros - Reporte por Estudiante</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('reportes.estudiante') }}" method="GET" target="_blank" id="formReporteEstudiante">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Estudiante *</label>
                        <select name="id_estudiante" id="selectEstudiante" class="form-control select2" required>
                            <option value="">-- Seleccione un estudiante --</option>
                            @if(isset($estudiantes) && count($estudiantes) > 0)
                                @foreach($estudiantes as $est)
                                    <option value="{{ $est->id }}">
                                        {{ $est->nombre }} {{ $est->ap_paterno }} {{ $est->ap_materno ?? '' }} - {{ $est->matricula }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>No hay estudiantes registrados</option>
                            @endif
                        </select>
                        <small class="text-muted">Seleccione o escriba para buscar por nombre o matrícula</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </button>
                    <button type="submit" formaction="{{ route('reportes.pdf.estudiante') }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reporte por Materia -->
<div class="modal fade" id="modalReporteMateria" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Filtros - Reporte por Materia</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('reportes.materia') }}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Materia *</label>
                        <select name="id_materia" class="form-control select2" required>
                            <option value="">Seleccione una materia</option>
                            @if(isset($materias))
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}">{{ $materia->nombre_materia }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semestre</label>
                        <select name="id_semestre" class="form-control select2">
                            <option value="">Todos</option>
                            @if(isset($semestres))
                                @foreach($semestres as $semestre)
                                    <option value="{{ $semestre->id }}">{{ $semestre->nombre_semestre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-theme@0.1.0-beta.10/dist/select2-bootstrap.min.css">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Select2 para todos los selects
    $('.select2').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: function() {
            return $(this).data('placeholder') || '-- Seleccione una opción --';
        },
        allowClear: true
    });

    // Select2 específico para búsqueda de estudiantes con búsqueda local
    $('#selectEstudiante').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: '-- Seleccione un estudiante --',
        allowClear: true
    });

    // Validación de formularios
    $('form').on('submit', function(e) {
        const requiredSelects = $(this).find('select[required]');
        let valid = true;

        requiredSelects.each(function() {
            if (!$(this).val()) {
                valid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!valid) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Campos requeridos',
                text: 'Por favor complete todos los campos obligatorios',
            });
            return false;
        }
    });

    // Gráfico de Asistencias de los últimos 7 días
    fetch('{{ route("reportes.graficos.general") }}')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('chartAsistencias7Dias').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'Presentes',
                            data: data.presentes,
                            borderColor: 'rgb(75, 192, 192)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            tension: 0.3
                        },
                        {
                            label: 'Ausentes',
                            data: data.ausentes,
                            borderColor: 'rgb(255, 99, 132)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false
                        }
                    }
                }
            });
        });

    // Gráfico Top 10 Estudiantes con más faltas
    fetch('{{ route("reportes.graficos.top-faltas") }}')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('chartTopFaltas').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Faltas',
                        data: data.data,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgb(255, 99, 132)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
});
</script>
@stop
