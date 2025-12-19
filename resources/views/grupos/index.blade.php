@extends('adminlte::page')

@section('title', 'Gestión de Grupos')

@section('content_header')
    <h1>Administración de Grupos</h1>
@stop

@section('content')
    <div class="table-responsive">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#mdlGrupo">
            + Nuevo Grupo
        </button>
        <table id="idTblGrupos" class="table table-striped table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Materia</th>
                    <th>Semestre</th>
                    <th>Docente</th>
                    <th>Aula</th>
                    <th>Turno</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mdlGrupo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar/Editar Grupo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmGrupo">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id_materia">Materia *</label>
                            <select class="form-control" id="id_materia" name="id_materia" required>
                                <option value="">-- Seleccione --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_semestre">Semestre *</label>
                            <select class="form-control" id="id_semestre" name="id_semestre" required>
                                <option value="">-- Seleccione --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_docente">Docente *</label>
                            <select class="form-control" id="id_docente" name="id_docente" required>
                                <option value="">-- Seleccione --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_aula">Aula *</label>
                            <select class="form-control" id="id_aula" name="id_aula" required>
                                <option value="">-- Seleccione --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_turno">Turno *</label>
                            <select class="form-control" id="id_turno" name="id_turno" required>
                                <option value="">-- Seleccione --</option>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let table;

        $(document).ready(function() {
            cargarSelectores();

            table = $('#idTblGrupos').DataTable({
                ajax: '{{ route('grupo.data') }}',
                columns: [
                    { data: 'id' },
                    { data: 'materia_nombre' },
                    { data: 'semestre_nombre' },
                    { data: 'docente_nombre' },
                    { data: 'aula_nombre' },
                    { data: 'turno_nombre' },
                    {
                        data: null,
                        orderable: false,
                        render: function(data) {
                            return `
                                <button class="btn btn-sm btn-warning btn-edit" data-id="${data.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${data.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                        }
                    }
                ],
                language: { url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json' }
            });

            // Submit form
            $('#frmGrupo').submit(function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let url = id ? '{{ route('grupo.update', ':id') }}'.replace(':id', id) : '{{ route('grupo.store') }}';

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(r) {
                        Swal.fire('Éxito', r.message || 'Operación exitosa', 'success');
                        $('#mdlGrupo').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message || xhr.responseJSON?.error || 'Ocurrió un error';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });

            // Editar
            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get('{{ route('grupo.show', ':id') }}'.replace(':id', id), function(data) {
                    $('#id').val(data.id);
                    $('#id_materia').val(data.id_materia);
                    $('#id_semestre').val(data.id_semestre);
                    $('#id_docente').val(data.id_docente);
                    $('#id_aula').val(data.id_aula);
                    $('#id_turno').val(data.id_turno);
                    $('#mdlGrupo').modal('show');
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
                            url: '{{ route('grupo.destroy', ':id') }}'.replace(':id', id),
                            method: 'POST',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function() {
                                Swal.fire('Eliminado', 'Registro eliminado correctamente', 'success');
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire('Error', xhr.responseJSON?.message || 'No se pudo eliminar', 'error');
                            }
                        });
                    }
                });
            });

            // Limpiar modal
            $('#mdlGrupo').on('hidden.bs.modal', function() {
                $('#frmGrupo')[0].reset();
                $('#id').val('');
            });
        });

        function cargarSelectores() {
            // Cargar materias
            $.get('{{ route('param.materias') }}', function(r) {
                $('#id_materia').html('<option value="">-- Seleccione --</option>');
                r.forEach(m => {
                    $('#id_materia').append(`<option value="${m.id}">${m.nombre_materia}</option>`);
                });
            });

            // Cargar docentes
            $.get('{{ route('docente.lista') }}', function(r) {
                $('#id_docente').html('<option value="">-- Seleccione --</option>');
                r.forEach(d => {
                    $('#id_docente').append(`<option value="${d.id}">${d.nombre_completo}</option>`);
                });
            });

            // Cargar semestres
            $.get('{{ route('param.semestres') }}', function(r) {
                $('#id_semestre').html('<option value="">-- Seleccione --</option>');
                r.forEach(s => {
                    $('#id_semestre').append(`<option value="${s.id}">${s.nombre_semestre}</option>`);
                });
            });

            // Cargar aulas
            $.get('{{ route('param.aulas') }}', function(r) {
                $('#id_aula').html('<option value="">-- Seleccione --</option>');
                r.forEach(a => {
                    $('#id_aula').append(`<option value="${a.id}">${a.codigo_aula}</option>`);
                });
            });

            // Cargar turnos
            $.get('{{ route('param.turnos') }}', function(r) {
                $('#id_turno').html('<option value="">-- Seleccione --</option>');
                r.forEach(t => {
                    $('#id_turno').append(`<option value="${t.id}">${t.nombre_turno}</option>`);
                });
            });
        }
    </script>
@stop
