@extends('adminlte::page')

@section('title', 'Lista de Carreras')

@section('content_header')
    <h1>Administracion de Carreras</h1>
@stop

@section('content')
    <table id="idTblCarreras" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    {{-- <th>Acciones</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse($carreras as $index => $carrera)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $carrera->nombre }}</td>
                        <td>{{ $carrera->descripcion }}</td>
                        <td>
                            @if($carrera->estado)
                                <span class="badge badge-success">Activa</span>
                            @else
                                <span class="badge badge-danger">Inactiva</span>
                            @endif
                        </td>
                        {{-- <td>
                            <a href="{{ route('carreras.edit', $carrera->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('carreras.destroy', $carrera->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar esta carrera?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td> --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No hay carreras disponibles.</td>
                    </tr>
                </tbody>
            @endforelse
        </table>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#idTblCarreras').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop
