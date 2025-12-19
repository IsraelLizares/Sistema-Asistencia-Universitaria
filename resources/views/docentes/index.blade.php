@extends('adminlte::page')

@section('title', 'Gestión de Docentes')

@section('content_header')
    <h1>Administración de Docentes</h1>
@stop

@section('content')
    <div class="table-responsive">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#mdlDocente">
            + Nuevo Docente
        </button>
        <table id="idTblDocentes" class="table table-striped table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>CI</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mdlDocente" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar/Editar Docente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmDocente">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="ap_paterno">Apellido Paterno *</label>
                            <input type="text" class="form-control" id="ap_paterno" name="ap_paterno" required>
                        </div>
                        <div class="form-group">
                            <label for="ap_materno">Apellido Materno</label>
                            <input type="text" class="form-control" id="ap_materno" name="ap_materno">
                        </div>
                        <div class="form-group">
                            <label for="ci">CI *</label>
                            <input type="text" class="form-control" id="ci" name="ci" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="celular">Celular *</label>
                            <input type="text" class="form-control" id="celular" name="celular" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion">
                        </div>
                        <div class="form-group">
                            <label for="profesion">Profesión</label>
                            <input type="text" class="form-control" id="profesion" name="profesion">
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
            table = $('#idTblDocentes').DataTable({
                ajax: '{{ route('docente.data') }}',
                columns: [
                    { data: 'id' },
                    { data: 'nombre_completo' },
                    { data: 'ci' },
                    { data: 'email' },
                    { data: 'celular' },
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
            $('#frmDocente').submit(function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let url = id ? '{{ route('docente.update', ':id') }}'.replace(':id', id) : '{{ route('docente.store') }}';

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(r) {
                        Swal.fire('Éxito', r.message || 'Operación exitosa', 'success');
                        $('#mdlDocente').modal('hide');
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
                $.get('{{ route('docente.show', ':id') }}'.replace(':id', id), function(data) {
                    $('#id').val(data.id);
                    $('#nombre').val(data.nombre);
                    $('#ap_paterno').val(data.ap_paterno);
                    $('#ap_materno').val(data.ap_materno);
                    $('#ci').val(data.ci);
                    $('#email').val(data.email);
                    $('#celular').val(data.celular);
                    $('#direccion').val(data.direccion);
                    $('#profesion').val(data.profesion);
                    $('#mdlDocente').modal('show');
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
                            url: '{{ route('docente.destroy', ':id') }}'.replace(':id', id),
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
            $('#mdlDocente').on('hidden.bs.modal', function() {
                $('#frmDocente')[0].reset();
                $('#id').val('');
            });
        });
    </script>
@stop
