@extends('layouts_page.app')

@section('title', 'Archivo Demasiado Grande')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                    </div>

                    <h1 class="text-danger mb-3">Archivo Demasiado Grande</h1>

                    <div class="alert alert-warning" role="alert">
                        <h5 class="alert-heading">¡Ups! El formulario es demasiado grande</h5>
                        <p class="mb-0">
                            El tamaño total de los archivos que intentas subir excede el límite permitido.
                            Por favor, reduce el tamaño de los archivos o sube menos archivos a la vez.
                        </p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-info-circle me-2"></i>Límites Recomendados
                                    </h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>Por archivo:</strong> Máximo 5MB</li>
                                        <li><strong>Formato:</strong> PDF o JPG</li>
                                        <li><strong>Total del formulario:</strong> Máximo 100MB</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-success">
                                        <i class="fas fa-lightbulb me-2"></i>Consejos
                                    </h6>
                                    <ul class="list-unstyled mb-0">
                                        <li>• Comprime los PDFs antes de subirlos</li>
                                        <li>• Usa imágenes JPG en lugar de PNG</li>
                                        <li>• Sube los archivos más importantes primero</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('inicio') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-arrow-left me-2"></i>Volver al Formulario
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-undo me-2"></i>Página Anterior
                        </button>
                    </div>

                    <div class="mt-4">
                        <small class="text-muted">
                            Si el problema persiste, contacta al administrador del sistema.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
