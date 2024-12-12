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
                    </div>
                </div>
            </div>
        </div>
        <!-- row  -->
        <div class="row my-6">

            <!-- card  -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="card h-100">
                    <!-- card header  -->
                    <div class="card-header bg-white py-4">
                        <h4 class="mb-0">Progenitores </h4>
                    </div>
                    <!-- table  -->
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombres Completos</th>
                                    <th>Tipo Doc.</th>
                                    <th>Nro. Doc.</th>
                                    <th>Cod. Sianet</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($progenitores as $progenitor)
                                    <tr>
                                        <td>{{ $progenitor->nombres }} {{ $progenitor->apellidos }} </td>
                                        <td>{{ $progenitor->tipo_documento }}</td>
                                        <td>{{ $progenitor->dni }}</td>
                                        <td>{{ $progenitor->codigo_sianet }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

