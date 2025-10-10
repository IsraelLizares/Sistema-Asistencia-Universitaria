@extends('adminlte::page')

@section('title', 'Lista de Carreras')

@section('content_header')
    <h1>Administracion de Carreras</h1>
@stop

@section('content')
    <div class="table-responsive">
        <table id="idTblCarreras" class="table table-striped table-bordered tablehover align-middle">
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#mdlCarrera">
                + Nueva Carrera
            </button>
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="mdlCarrera" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Carrera</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmCarrera">
                    @csrf {{-- Laravel CSRF token --}}
                    <input type="hidden" id="id" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="formlabel">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="formlabel">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion">
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
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

@stop

@section('js')
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

    {{-- Sweeet Alert 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/alert.js')

    <script>
        $(function() {
            $('#idTblCarreras').DataTable({
                ajax: '{{ route('carrera.data') }}',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: 'descripcion',
                    },
                    {
                        data: 'estado',
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            let eliminarCarrera = `
                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarCarrera(${data})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            `;
                            let editarCarrera = `
                            <button type="button" class="btn btn-primary btn-sm" onclick="modificarCarrera(${data})">
                                <i class="fas fa-edit"></i>
                            </button>
                            `;
                            return editarCarrera + eliminarCarrera;
                        }
                    },
                ],
                language: {
                    // url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                }
            });
        });

        function eliminarCarrera(id) {
            Swal.fire({
                title: '¿Eliminar carrera?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/carrera/destroy/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(res => res.json())
                        .then(() => {
                            Swal.fire('Eliminado', 'La carrera fue eliminado', 'success');
                            $('#idTblCarreras').DataTable().ajax.reload();
                        })
                        .catch(() => {
                            Swal.fire('Error', 'No se pudo eliminar', 'error');
                        });
                }
            });
        }

        function llenarFormularioCarrera(data) {
            document.getElementById('id').value = data.id ?? '';
            document.getElementById('nombre').value = data.nombre ?? '';
            document.getElementById('descripcion').value = data.descripcion ?? '';
        }
        // 🔹 Función: obtiene el producto y abre el modal para editar
        function modificarCarrera(id) {
            fetch(`/carrera/show/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        // Usar helper para llenar campos
                        llenarFormularioCarrera(data);
                        // Abrir modal
                        // var modal = new bootstrap.Modal(document.getElementById('mdlCarrera'));
                        // modal.show();
                        $('#mdlCarrera').modal('show');
                    } else {
                        Swal.fire('Error', 'No se encontró el producto', 'error');
                    }
                })
                .catch((e) => {
                    console.log(e);
                    Swal.fire('Error', 'No se pudo cargar el producto', 'error');
                });
        }
    </script>

    {{-- CREATE AND UPDATE JSON --}}
    <script>
        // 🔹 Helper: decide si es CREATE o UPDATE
        function getCarreraRequestConfig(form) {
            console.log('Formulario:', form);
            // console.log(JSON.stringify(form));
            let id = document.getElementById('id').value;
            let url;
            let method = 'POST'; // siempre POST
            let formData = new FormData(form);
            if (id && id > 0) {
                url = `/carrera/${id}`; // actualiza carrera
            } else {
                url = "{{ route('carrera.store') }}"; // crea carrera
            }
            return {
                url,
                method:'POST',
                formData
            };
        }
        // 🔹 Submit del formulario
        $('#frmCarrera').submit(function(e) {
            e.preventDefault(); // evitar recarga de página

            let config = getCarreraRequestConfig(this);
            fetch(config.url, {
                method: config.method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: config.formData
            })
            .then(r => r.json())
            .then(res => {
                // alert(JSON.stringify(res,null, 2));
                Swal.fire({
                    position: "top-end",
                    icon: res.success ? "success" : "error",
                    title: res.message ?? 'Error inesperado',
                    showConfirmButton: false,
                    timer: 1500
                });
                if (res.success) {
                    this.reset(); // limpia el formulario
                    document.getElementById('id').value = '';
                    console.log('Valor de Id oculto: ',id);
                    $('#idTblCarreras').DataTable().ajax.reload(); // recarga datatable
                    $('#mdlCarrera').modal('hide');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'No se pudo procesar la petición', 'error');
            });
        });
    </script>


    {{-- <script>
        document.querySelector('#frmCarrera').onsubmit = e => {
            e.preventDefault();
            fetch('{{ route('carrera.store') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: new FormData(e.target) // ✅ incluye _token
                })
                .then(r => r.json())
                .then(() => alert('Carrera guardado'));
        };
    </script> --}}

    {{-- <script>
        $('#frmCarrera').submit(function(e) {
            e.preventDefault(); // evita recargar
            fetch('{{ route('carrera.store') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: new FormData(this) // incluye _token
                })
                .then(r => r.json())
                .then(res => {
                    mostrarAlertaMsgOk('Guardado con exito!');
                    this.reset(); // limpia form
                    $('#idTblCarreras').DataTable().ajax.reload(); // recarga tabla
                    $('#mdlCarrera').modal('hide');

                });
        });
    </script> --}}



@stop
