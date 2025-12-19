@extends('adminlte::page')

@section('title', 'Registrar Asistencia')

@section('content_header')
    <h1>Registro de Asistencia</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="frmSeleccion">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fecha *</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Grupo *</label>
                            <select name="id_grupo" id="id_grupo" class="form-control" required>
                                <option value="">-- Seleccione un grupo --</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" id="btnCargar" class="btn btn-info btn-block">
                                <i class="fas fa-search"></i> Cargar
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div id="divEstudiantes" style="display:none;">
                <hr>
                <h5>Lista de Estudiantes</h5>
                <form id="frmAsistencia">
                    @csrf
                    <input type="hidden" name="fecha" id="fecha_hidden">
                    <input type="hidden" name="id_grupo" id="id_grupo_hidden">

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Estudiante</th>
                                    <th>Matrícula</th>
                                    <th width="150" class="text-center">Estado</th>
                                    <th width="200">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyEstudiantes"></tbody>
                        </table>
                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Guardar Asistencia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .estado-presente { background-color: #d4edda; }
        .estado-ausente { background-color: #f8d7da; }
        .estado-justificado { background-color: #fff3cd; }
    </style>
@stop

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Cargar grupos
            $.get('{{ route('grupo.lista') }}', function(response) {
                $('#id_grupo').html('<option value="">-- Seleccione un grupo --</option>');
                response.forEach(g => {
                    $('#id_grupo').append(`<option value="${g.id}">${g.nombre}</option>`);
                });
            });

            // Cargar estudiantes del grupo
            $('#btnCargar').click(function() {
                let grupoId = $('#id_grupo').val();
                let fecha = $('#fecha').val();

                if (!grupoId || !fecha) {
                    Swal.fire('Advertencia', 'Debe seleccionar un grupo y una fecha', 'warning');
                    return;
                }

                // Limpiar tabla antes de cargar
                $('#tbodyEstudiantes').html('');
                $('#divEstudiantes').hide();

                $.ajax({
                    url: '{{ route('asistencia.estudiantes') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_grupo: grupoId,
                        fecha: fecha
                    },
                    success: function(response) {
                        if (!response.estudiantes || response.estudiantes.length === 0) {
                            Swal.fire('Información', 'No hay estudiantes inscritos en este grupo', 'info');
                            $('#tbodyEstudiantes').html('');
                            $('#divEstudiantes').hide();
                            return;
                        }

                        $('#fecha_hidden').val(fecha);
                        $('#id_grupo_hidden').val(grupoId);

                        $('#tbodyEstudiantes').html('');
                        response.estudiantes.forEach((est, i) => {
                            let nombre = est.nombre + ' ' + est.ap_paterno + (est.ap_materno ? ' ' + est.ap_materno : '');
                            let estadoDefault = response.asistencias[est.id] || 'presente';
                            let observacionDefault = response.observaciones[est.id] || '';

                            $('#tbodyEstudiantes').append(`
                                <tr class="fila-estudiante estado-${estadoDefault}">
                                    <td class="text-center">${i+1}</td>
                                    <td>${nombre}</td>
                                    <td>${est.matricula}</td>
                                    <td class="text-center">
                                        <input type="hidden" name="asistencias[${i}][id_estudiante]" value="${est.id}">
                                        <select name="asistencias[${i}][estado_asistencia]" class="form-control form-control-sm select-estado" required>
                                            <option value="presente" ${estadoDefault === 'presente' ? 'selected' : ''}>Presente</option>
                                            <option value="ausente" ${estadoDefault === 'ausente' ? 'selected' : ''}>Ausente</option>
                                            <option value="justificado" ${estadoDefault === 'justificado' ? 'selected' : ''}>Justificado</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="asistencias[${i}][observacion]" class="form-control form-control-sm" placeholder="Opcional" value="${observacionDefault}">
                                    </td>
                                </tr>
                            `);
                        });

                        $('#divEstudiantes').show();

                        // Cambiar color de fila según estado
                        $('.select-estado').change(function() {
                            let fila = $(this).closest('tr');
                            fila.removeClass('estado-presente estado-ausente estado-justificado');
                            fila.addClass('estado-' + $(this).val().toLowerCase());
                        });

                        // Aplicar color inicial
                        $('.select-estado').trigger('change');

                        // Mostrar advertencia si ya existe sesión y deshabilitar guardado
                        if (response.sesion_existente) {
                            $('#frmAsistencia button[type="submit"]').prop('disabled', true);
                            $('#frmAsistencia select, #frmAsistencia input[type="text"]').prop('disabled', true);
                            Swal.fire({
                                title: 'Sesión ya registrada',
                                text: 'Ya existe asistencia registrada para esta fecha. Los datos son de solo lectura.',
                                icon: 'warning',
                                confirmButtonText: 'Entendido'
                            });
                        } else {
                            $('#frmAsistencia button[type="submit"]').prop('disabled', false);
                            $('#frmAsistencia select, #frmAsistencia input[type="text"]').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        let mensaje = 'Error al cargar estudiantes';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            mensaje = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            mensaje = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', mensaje, 'error');
                        console.error('Error completo:', xhr);
                    }
                });
            });

            // Guardar asistencia
            $('#frmAsistencia').submit(function(e) {
                e.preventDefault();

                // Validar que haya al menos un estudiante
                if ($('#tbodyEstudiantes tr').length === 0) {
                    Swal.fire('Advertencia', 'No hay estudiantes para registrar asistencia', 'warning');
                    return;
                }

                // Validar que todos tengan estado seleccionado
                let todosCompletos = true;
                $('.select-estado').each(function() {
                    if (!$(this).val()) {
                        todosCompletos = false;
                        return false;
                    }
                });

                if (!todosCompletos) {
                    Swal.fire('Advertencia', 'Debe seleccionar el estado de asistencia para todos los estudiantes', 'warning');
                    return;
                }

                let formData = $(this).serialize();

                Swal.fire({
                    title: '¿Guardar asistencia?',
                    text: "Verifique que todos los datos sean correctos. Esta acción no se puede revertir.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('asistencia.store') }}',
                            method: 'POST',
                            data: formData,
                            success: function(response) {
                                Swal.fire('Éxito', response.message || 'Asistencia registrada correctamente', 'success').then(() => {
                                    // Limpiar formulario y ocultar tabla
                                    $('#frmSeleccion')[0].reset();
                                    $('#tbodyEstudiantes').html('');
                                    $('#divEstudiantes').hide();
                                    $('#fecha').val('{{ date('Y-m-d') }}');
                                    $('#id_grupo').val('');
                                });
                            },
                            error: function(xhr) {
                                let mensaje = 'Error al registrar la asistencia';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    mensaje = xhr.responseJSON.message;
                                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    mensaje = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                                }
                                Swal.fire('Error', mensaje, 'error');
                                console.error('Error completo:', xhr);
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop
