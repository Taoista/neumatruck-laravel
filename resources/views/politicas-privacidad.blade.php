@extends('layouts.template')

@section('content-general')
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ url('./') }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
                        <li><a href="javascript:void(0);">GARANTÍAS DE DEVOLUCIONES</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="titulo">Políticas de Privacidad de la Aplicación Móvil</h2>
                    <hr class="amarillo">
                </div>
            </div>

            <div class="row">
                <p>
                    Bienvenido a Neumatruck una aplicación móvil desarrollada . En Neumatruck nos tomamos en serio la privacidad de nuestros usuarios. Esta política de privacidad describe cómo recopilamos, utilizamos y protegemos la información que recopilamos a través de nuestra aplicación.
                </p>
                
                <!-- Agrega más contenido aquí, como información sobre la recopilación de datos, el propósito, el almacenamiento, etc. -->

                <p>
                    Al utilizar Neumatruck aceptas las prácticas descritas en esta política de privacidad. Te recomendamos que leas detenidamente este documento y que lo consultes periódicamente para estar al tanto de cualquier cambio.
                </p>
            </div>
        </div>
    </div>
@endsection
