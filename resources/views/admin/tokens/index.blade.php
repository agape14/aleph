@extends('layouts.admin')

@section('title', 'Gestión de Tokens de Menú - Administración')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Gestión de Tokens de Menú</h3>
                    <p class="text-white-50">Activa/desactiva menús y funcionalidades del sistema</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tokens de Menú -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tokens de Activación</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Token</th>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Usos</th>
                                    <th>Expiración</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tokens as $token)
                                <tr>
                                    <td>
                                        <code>{{ $token->token }}</code>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($token->tipo) }}</span>
                                    </td>
                                    <td>{{ $token->nombre }}</td>
                                    <td>
                                        <span class="badge bg-{{ $token->activo ? 'success' : 'secondary' }}">
                                            {{ $token->activo ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>{{ $token->usos_actuales }} / {{ $token->usos_maximos }}</td>
                                    <td>{{ $token->fecha_expiracion ? $token->fecha_expiracion->format('d/m/Y') : 'Sin expiración' }}</td>
                                    <td>
                                        @if($token->activo)
                                            <button class="btn btn-sm btn-warning" onclick="toggleToken('{{ $token->token }}', false)">
                                                <i class="fas fa-pause"></i> Desactivar
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-success" onclick="toggleToken('{{ $token->token }}', true)">
                                                <i class="fas fa-play"></i> Activar
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles de Contenido -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Roles de Contenido</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Token de Activación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $rol)
                                <tr>
                                    <td>{{ $rol->nombre }}</td>
                                    <td>{{ $rol->descripcion }}</td>
                                    <td>
                                        <span class="badge bg-{{ $rol->activo ? 'success' : 'secondary' }}">
                                            {{ $rol->activo ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <code>{{ $rol->token_activacion }}</code>
                                    </td>
                                    <td>
                                        @if($rol->activo)
                                            <button class="btn btn-sm btn-warning" onclick="toggleRol({{ $rol->id }}, false)">
                                                <i class="fas fa-pause"></i> Desactivar
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-success" onclick="toggleRol({{ $rol->id }}, true)">
                                                <i class="fas fa-play"></i> Activar
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activación por Token -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Activación Rápida por Token</h5>
                </div>
                <div class="card-body">
                    <form id="activarTokenForm">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="tokenInput" placeholder="Ingrese el token de activación">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key"></i> Activar Token
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleToken(token, activar) {
    const url = activar ? `/admin/tokens/${token}/activar` : `/admin/tokens/${token}/desactivar`;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cambiar el estado del token');
    });
}

function toggleRol(rolId, activar) {
    const url = activar ? `/admin/tokens/rol/${rolId}/activar` : `/admin/tokens/rol/${rolId}/desactivar`;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cambiar el estado del rol');
    });
}

document.getElementById('activarTokenForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const token = document.getElementById('tokenInput').value;

    fetch('/api/activar-funcionalidad', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ token: token })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Token activado exitosamente');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al activar el token');
    });
});
</script>
@endsection
