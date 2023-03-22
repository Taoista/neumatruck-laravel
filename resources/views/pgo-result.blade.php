@extends('layouts.template')

@section('content-general')
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ url('./') }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
                        <li><a href="javascript:void(0);">Pago Transbank</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section">

        <div class="container">

            <div class="row">

                <div class="col-md-12">
                    <h2 class="titulo">Error</h2>
                    <hr class="amarillo">
                </div>

                <div class="section">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-7">
                            <h3>Ocurrió un error</h3>
                            <p>Las posibles causas de este rechazo son:</p>
                            <p>* Error en el ingreso de los datos de su tarjeta de Crédito o Débito (fecha y/o código de seguridad).</p>
                            <p>* Su tarjeta de Crédito o Débito no cuenta con saldo suficiente.</p>
                            <p>* Tarjeta aún no habilitada en el sistema financiero.</p>
                            <p>* Tu dispostivo de verificación no tiene internet</p>
                            <p>* Cancelo el proceso de pago.</p>
                        </div>
                        <div class="col-md-5">
                          <div class="section-title text-center">
                            <img src="{{ asset('assets/img/img_contacto.jpg') }}" class="img-responsive">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
@endsection
