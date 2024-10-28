@extends('layouts.layout')

@section('title', 'Usuarios')

@section('content')
<div class="container">
    <h1>Lista de Usuarios</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Fecha de Registro</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->fecha_registro ? \Carbon\Carbon::parse($user->fecha_registro)->format('d/m/Y') : 'No disponible' }}</td>
                    <td>
                        @if($user->foto)
                            <img src="{{ asset('storage/'.$user->foto) }}" alt="Foto de {{ $user->name }}" width="50">
                        @else
                            No disponible
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $user->status ? 'badge-success' : 'badge-danger' }}">
                            {{ $user->status ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td>
                        <!-- Botón para abrir el modal de edición -->
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editUserModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-role="{{ $user->role }}" data-foto="{{ asset('storage/'.$user->foto) }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <!-- Icono para desactivar/activar usuario -->
                        <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-secondary" title="Desactivar/Activar Usuario">
                                <i class="fas fa-user-slash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal de Edición -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editUserForm" action="{{ url('users/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Campos para editar -->
                    <input type="hidden" name="id" id="editUserId">
                    <div class="form-group">
                        <label for="editUserName">Nombre</label>
                        <input type="text" name="name" id="editUserName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editUserEmail">Correo Electrónico</label>
                        <input type="email" name="email" id="editUserEmail" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editUserRole">Rol</label>
                        <select name="role" id="editUserRole" class="form-control" required>
                            <option value="admin">Administrador</option>
                            <option value="doctor">Doctor</option>
                            <option value="nurse">Enfermero</option>
                            <option value="lab_tech">Técnico de Laboratorio</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editUserFoto">Imagen de Perfil</label>
                        <input type="file" name="foto" id="editUserFoto" class="form-control-file">
                        <img id="currentUserFoto" src="" alt="Imagen de perfil actual" width="100">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#editUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var email = button.data('email');
        var role = button.data('role');
        var foto = button.data('foto');

        var modal = $(this);
        modal.find('#editUserForm').attr('action', '{{ url("users") }}/' + id);
        modal.find('#editUserId').val(id);
        modal.find('#editUserName').val(name);
        modal.find('#editUserEmail').val(email);
        modal.find('#editUserRole').val(role);
        modal.find('#currentUserFoto').attr('src', foto);
    });
});
</script>
@endsection

