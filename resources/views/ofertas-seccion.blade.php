@extends('layouts.template')

@section('content-general')
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ url('./') }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
                        <li><a href="javascript:void(0);">ofertas</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section">

        <div class="container">

            <div class="row">

                <div class="col-md-12">
                    <h2 class="titulo">{{ $nombre }}</h2>
                    <hr class="amarillo">
                </div>

                @livewire("ofertas-seccion", ['id_oferta' => $id_oferta])

            </div>
        </div>
    </div>
@endsection
