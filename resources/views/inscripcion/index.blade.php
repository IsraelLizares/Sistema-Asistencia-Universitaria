@extends('adminlte::page')

@section('title', 'Inscripciones')

@section('content_header')
    <h1>Gestión de Inscripciones</h1>
@stop

@section('content')
    <div class="table-responsive">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalInscripcion">
            <i class="fas fa-plus"></i> Nueva Inscripción
        </button>
        <table id="tableInscripciones" class="table table-striped table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Estudiante</th>
                    <th>Materia</th>
                    <th>Semestre</th>
                    <th>Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalInscripcion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inscripción</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formInscripcion">
                    @csrf
                    <input type="hidden" id="inscripcion_id" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Carrera (filtro)</label>
                            <select class="form-control" id="filter_carrera">
                                <option value="">-- Todas las carreras --</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Estudiante *</label>
                            <select class="form-control" id="id_estudiante" name="id_estudiante" required>
                                <option value="">-- Seleccione --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Grupo (Materia - Semestre - Turno) *</label>
                            <select class="form-control" id="id_grupo" name="id_grupo" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">
                                        {{ $grupo->materia->nombre_materia ?? 'N/A' }} -
                                        {{ $grupo->semestre->nombre_semestre ?? 'N/A' }} -
                                        {{ $grupo->turno->nombre_turno ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        // DataTable
        let table = $('#tableInscripciones').DataTable({
            ajax: '{{ route('inscripcion.data') }}',
            columns: [
                {data: 'id'},
                {data: 'estudiante_nombre'},
                {data: 'materia_nombre'},
                {data: 'semestre_nombre'},
                {data: 'carrera_nombre'},
                {
                    data: null,
                    orderable: false,
                    render: function(data) {
                        return `
                            <button type="button" class="btn btn-sm btn-warning btn-edit" data-id="${data.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${data.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ],
            language: {url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'}
        });

        // Cargar estudiantes inicialmente y al cambiar carrera
        function cargarEstudiantes(carreraId = '') {
            $.get('{{ route('estudiante.data') }}', function(data) {
                let estudiantes = carreraId ? data.data.filter(e => e.id_carrera == carreraId) : data.data;
                $('#id_estudiante').html('<option value="">-- Seleccione --</option>');
                estudiantes.forEach(e => {
                    let nombre = e.nombre + ' ' + e.ap_paterno + (e.ap_materno ? ' ' + e.ap_materno : '');
                    $('#id_estudiante').append(`<option value="${e.id}">${nombre}</option>`);
                });
            });
        }

        // Cargar estudiantes al abrir modal
        $('#modalInscripcion').on('show.bs.modal', function() {
            if (!$('#inscripcion_id').val()) {
                cargarEstudiantes();
            }
        });

        $('#filter_carrera').change(function() {
            cargarEstudiantes($(this).val());
        });

        // Crear/Actualizar
        $('#formInscripcion').submit(function(e) {
            e.preventDefault();
            let id = $('#inscripcion_id').val();
            let url = id ? '{{ route('inscripcion.update', ':id') }}'.replace(':id', id) : '{{ route('inscripcion.store') }}';

            $.ajax({
                url: url,
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire('Éxito', response.success, 'success');
                    $('#modalInscripcion').modal('hide');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON.error || 'Ocurrió un error', 'error');
                }
            });
        });

        // Editar
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $.get('{{ route('inscripcion.show', ':id') }}'.replace(':id', id), function(data) {
                $('#inscripcion_id').val(data.id);
                cargarEstudiantes(data.estudiante.id_carrera);
                setTimeout(function() {
                    $('#id_estudiante').val(data.id_estudiante);
                    $('#id_grupo').val(data.id_grupo);
                    $('#filter_carrera').val(data.estudiante.id_carrera);
                }, 300);
                $('#modalInscripcion').modal('show');
            });
        });

        // Eliminar
        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción no se puede revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('inscripcion.destroy', ':id') }}'.replace(':id', id),
                        method: 'POST',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function() {
                            Swal.fire('Eliminado', 'Inscripción eliminada', 'success');
                            table.ajax.reload();
                        }
                    });
                }
            });
        });

        // Limpiar formulario al cerrar modal
        $('#modalInscripcion').on('hidden.bs.modal', function() {
            $('#formInscripcion')[0].reset();
            $('#inscripcion_id').val('');
        });
    });
    </script>
@stop
