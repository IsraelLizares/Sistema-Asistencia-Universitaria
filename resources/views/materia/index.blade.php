@extends('adminlte::page')

@section('title', 'Lista de Materias')

@section('content_header')
    <h1>Administracion de Materias</h1>
@stop

@section('content')
    <div class="table-responsive">
        <table id="idTblMaterias" class="table table-striped table-bordered tablehover align-middle">
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#mdlMateria">
                + Nueva Materia
            </button>
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Carrera</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mdlMateria" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Materia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmMateria">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombrea" class="formlabel">Nombre</label>
                            <input type="text" class="form-control" id="nombrea" name="nombrea" required>
                        </div>
                        <div class="mb-3">
                            <label for="codigo" class="formlabel">Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" required>
                        </div>
                        <div class="mb-3">
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
    @vite('resources/css/style.css')
@stop

@section('js')
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/alert.js')
    <script>
        $(function() {
            $('#idTblMaterias').DataTable({
                ajax: '{{ route('materia.data') }}',
                columns: [
                    { data: 'id' },
                    { data: 'nombrea' },
                    { data: 'codigo' },
                    { data: 'id_carrera' },
                    { data: 'estado' },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            let eliminarMateria = `<button type="button" class="btn btn-danger btn-sm" onclick="eliminarMateria(${data})"><i class="fas fa-trash-alt"></i></button>`;
                            let editarMateria = `<button type="button" class="btn btn-primary btn-sm" onclick="modificarMateria(${data})"><i class="fas fa-edit"></i></button>`;
                            return editarMateria + eliminarMateria;
                        }
                    },
                ],
            });
        });
        function eliminarMateria(id) {
            Swal.fire({
                title: '¿Eliminar materia?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/materia/destroy/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(res => res.json())
                    .then(() => {
                        Swal.fire('Eliminado', 'La materia fue eliminada', 'success');
                        $('#idTblMaterias').DataTable().ajax.reload();
                    })
                    .catch(() => {
                        Swal.fire('Error', 'No se pudo eliminar', 'error');
                    });
                }
            });
        }
        function llenarFormularioMateria(data) {
            document.getElementById('id').value = data.id ?? '';
            document.getElementById('nombrea').value = data.nombrea ?? '';
            document.getElementById('codigo').value = data.codigo ?? '';
            document.getElementById('id_carrera').value = data.id_carrera ?? '';
        }
        function modificarMateria(id) {
            fetch(`/materia/show/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        llenarFormularioMateria(data);
                        $('#mdlMateria').modal('show');
                    } else {
                        Swal.fire('Error', 'No se encontró la materia', 'error');
                    }
                })
                .catch((e) => {
                    console.log(e);
                    Swal.fire('Error', 'No se pudo cargar la materia', 'error');
                });
        }
        function getMateriaRequestConfig(form) {
            let id = document.getElementById('id').value;
            let url;
            let method = 'POST';
            let formData = new FormData(form);
            if (id && id > 0) {
                url = `/materia/${id}`;
            } else {
                url = "{{ route('materia.store') }}";
            }
            return {
                url,
                method,
                formData
            };
        }
        $('#frmMateria').submit(function(e) {
            e.preventDefault();
            let config = getMateriaRequestConfig(this);
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
                    $('#idTblMaterias').DataTable().ajax.reload();
                    document.getElementById('id').value = '';
                    $('#mdlMateria').modal('hide');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'No se pudo procesar la petición', 'error');
            });
        });
    </script>
@stop
