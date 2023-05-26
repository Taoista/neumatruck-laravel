@extends('layouts.template')

@section('content-general')
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ url('./') }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
                        <li><a href="javascript:void(0);">ofertas {{ get_title_of_especial() }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section">

        <div class="container">

            <div class="row">

                <div class="col-md-12">
                    <h2 class="titulo">Ofertas  {{ get_title_of_especial() }}</h2>
                    <hr class="amarillo">
                </div>

                
                @livewire("ofertas-special-date")
                {{-- @livewire("ofertas-especiales") --}}

            </div>
        </div>
    </div>
@endsection
