@extends('adminlte::page')

@section('title', 'Lista de Estudiantes')

@section('content_header')
    <h1>Administracion de Estudiantes</h1>
@stop

@section('content')
    <div class="table-responsive">
        <table id="idTblEstudiantes" class="table table-striped table-bordered tablehover align-middle">
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#mdlEstudiante">
                + Nuevo Estudiante
            </button>
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ap. Paterno</th>
                    <th>Ap. Materno</th>
                    <th>CI</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <th>Fecha Nac.</th>
                    <th>Carrera</th>
                    <th>Turno</th>
                    <th>Matrícula</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mdlEstudiante" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmEstudiante">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre" class="formlabel">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ap_paterno" class="formlabel">Apellido Paterno</label>
                                <input type="text" class="form-control" id="ap_paterno" name="ap_paterno" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ap_materno" class="formlabel">Apellido Materno</label>
                                <input type="text" class="form-control" id="ap_materno" name="ap_materno">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ci" class="formlabel">CI</label>
                                <input type="text" class="form-control" id="ci" name="ci" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="formlabel">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="email" class="formlabel">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="direccion" class="formlabel">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha_nacimiento" class="formlabel">Fecha Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="turno" class="formlabel">Turno</label>
                                <select class="form-control" id="turno" name="turno" required>
                                    <option value="">Seleccione turno</option>
                                    <option value="mañana">Mañana</option>
                                    <option value="noche">Noche</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="matricula" class="formlabel">Matrícula</label>
                                <input type="text" class="form-control" id="matricula" name="matricula" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_carrera" class="formlabel">Carrera</label>
                                <select class="form-control" id="id_carrera" name="id_carrera" required>
                                    <option value="">Seleccione una carrera</option>
                                    @isset($carreras)
                                        @foreach($carreras as $carrera)
                                            <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btnprimary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            $('#idTblEstudiantes').DataTable({
                ajax: '{{ route('estudiante.data') }}',
                columns: [
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'ap_paterno' },
                    { data: 'ap_materno' },
                    { data: 'ci' },
                    { data: 'telefono' },
                    { data: 'email' },
                    { data: 'direccion' },
                    { data: 'fecha_nacimiento' },
                    { data: 'id_carrera' },
                    { data: 'turno' },
                    { data: 'matricula' },
                    { data: 'estado' },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            let eliminarEstudiante = `<button type="button" class="btn btn-danger btn-sm" onclick="eliminarEstudiante(${data})"><i class="fas fa-trash-alt"></i></button>`;
                            let editarEstudiante = `<button type="button" class="btn btn-primary btn-sm" onclick="modificarEstudiante(${data})"><i class="fas fa-edit"></i></button>`;
                            return editarEstudiante + eliminarEstudiante;
                        }
                    },
                ],
            });
        });
        function eliminarEstudiante(id) {
            Swal.fire({
                title: '¿Eliminar estudiante?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/estudiante/destroy/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(res => res.json())
                    .then(() => {
                        Swal.fire('Eliminado', 'El estudiante fue eliminado', 'success');
                        $('#idTblEstudiantes').DataTable().ajax.reload();
                    })
                    .catch(() => {
                        Swal.fire('Error', 'No se pudo eliminar', 'error');
                    });
                }
            });
        }
        function llenarFormularioEstudiante(data) {
            document.getElementById('id').value = data.id ?? '';
            document.getElementById('nombre').value = data.nombre ?? '';
            document.getElementById('ap_paterno').value = data.ap_paterno ?? '';
            document.getElementById('ap_materno').value = data.ap_materno ?? '';
            document.getElementById('ci').value = data.ci ?? '';
            document.getElementById('telefono').value = data.telefono ?? '';
            document.getElementById('email').value = data.email ?? '';
            document.getElementById('direccion').value = data.direccion ?? '';
            document.getElementById('fecha_nacimiento').value = data.fecha_nacimiento ?? '';
            document.getElementById('id_carrera').value = data.id_carrera ?? '';
            document.getElementById('turno').value = data.turno ?? '';
            document.getElementById('matricula').value = data.matricula ?? '';
        }
        function modificarEstudiante(id) {
            fetch(`/estudiante/show/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        llenarFormularioEstudiante(data);
                        $('#mdlEstudiante').modal('show');
                    } else {
                        Swal.fire('Error', 'No se encontró el estudiante', 'error');
                    }
                })
                .catch((e) => {
                    console.log(e);
                    Swal.fire('Error', 'No se pudo cargar el estudiante', 'error');
                });
        }
        function getEstudianteRequestConfig(form) {
            let id = document.getElementById('id').value;
            let url;
            let method = 'POST';
            let formData = new FormData(form);
            if (id && id > 0) {
                url = `/estudiante/${id}`;
            } else {
                url = "{{ route('estudiante.store') }}";
            }
            return {
                url,
                method,
                formData
            };
        }
        $('#frmEstudiante').submit(function(e) {
            e.preventDefault();
            let config = getEstudianteRequestConfig(this);
            fetch(config.url, {
                method: config.method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: config.formData
            })
            .then(r => r.json())
            .then(res => {
                Swal.fire({
                    position: "top-end",
                    icon: res.success ? "success" : "error",
                    title: res.message ?? 'Error inesperado',
                    showConfirmButton: false,
                    timer: 1500
                });
                if (res.success) {
                    this.reset();
                    document.getElementById('id').value = '';
                    $('#idTblEstudiantes').DataTable().ajax.reload();
                    $('#mdlEstudiante').modal('hide');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'No se pudo procesar la petición', 'error');
            });
        });
    </script>
@stop
