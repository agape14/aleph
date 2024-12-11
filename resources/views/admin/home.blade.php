@extends('layouts.admin')

@section('content')
    <div class="bg-dark-info pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page header -->
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Bienvenido {{ ucfirst(Auth::user()->role) }}</h3>
                        </div>
                        <div>
                            <a href="#" class="btn btn-white">Nueno proyecto</a>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card bg-light-success">
                    <!-- card body -->
                    <div class="card-body ">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center text-success  mb-3">
                            <div>
                                <h4 class="mb-0">Diario</h4>
                            </div>
                            <div class="icon-shape icon-md bg-success text-white  rounded-2">
                                <i class="bi bi-briefcase fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold text-success">18</h1>
                            <p class="mb-0">Registrados</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card bg-light-primary">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center   mb-3">
                            <div>
                                <h4 class="mb-0 ">Semanal</h4>
                            </div>
                            <div class="icon-shape icon-md bg-primary text-white rounded-2">
                                <i class="bi bi-list-task fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold text-primary">13</h1>
                            <p class="mb-0">Registrados</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card bg-light-warning">
                    <!-- card body -->
                    <div class="card-body ">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Mensual</h4>
                            </div>
                            <div class="icon-shape icon-md bg-warning text-white rounded-2">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold">12</h1>
                            <p class="mb-0">Registrados</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card bg-light-info ">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Anual</h4>
                            </div>
                            <div class="icon-shape icon-md bg-info text-white rounded-2">
                                <i class="bi bi-bullseye fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold">176</h1>
                            <p class="mb-0">Registrados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row  -->
        <div class="row mt-6">
            <div class="col-md-12 col-12">
                <!-- card  -->
                <div class="card">
                    <!-- card header  -->
                    <div class="card-header bg-white  py-4">
                        <h4 class="mb-0">Listado de Solicitudes</h4>
                    </div>
                    <!-- table  -->
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Estudiante</th>
                                    <th>DNI</th>
                                    <th>Estado</th>
                                    <th>Progenitores</th>
                                    <th>Progreso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="icon-shape icon-md border p-4  rounded-1">
                                                    <img src="{{ asset('admin_assets/images/brand/github-logo.svg') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="ms-3 lh-1">
                                                <h5 class=" mb-1"> <a href="#" class="text-inherit">Dropbox Design
                                                        System</a></h5>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">34</td>
                                    <td class="align-middle"><span class="badge  bg-warning">Medium</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="avatar-group">
                                            <span class="avatar avatar-sm">
                                                <img alt="avatar" src="{{asset('admin_assets/images/avatar/avatar-1.jpg')}}"
                                                    class="rounded-circle">
                                            </span>
                                            <span class="avatar avatar-sm">
                                                <img alt="avatar" src="{{asset('admin_assets/images/avatar/avatar-2.jpg')}}"
                                                    class="rounded-circle">
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-dark">
                                        <div class="float-start me-3">15%</div>
                                        <div class="mt-2">
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar" role="progressbar" style="width:15%"
                                                    aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                    <!-- card footer  -->
                    <div class="card-footer bg-white text-center">
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


