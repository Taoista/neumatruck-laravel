@extends('layouts.template')

@section('content-css')



@endsection


@section('content-general')
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ url('./') }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
                        <li><a href="javascript:void(0);">Checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @livewire("checkout2")

@endsection


