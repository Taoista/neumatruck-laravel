@extends('layouts.template')

@section('content-css')

<style>

.input-number-group {
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-justify-content: center;
      -ms-flex-pack: center;
          justify-content: center;
}

.input-number-group input[type=number]::-webkit-inner-spin-button,
.input-number-group input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
          appearance: none;
}

.input-number-group .input-group-button {
  line-height: calc(80px/2 - 5px);
}

.input-number-group .input-number {
  width: 80px;
  padding: 0 12px;
  vertical-align: top;
  text-align: center;
  outline: none;
  display: block;
  margin: 0;
}

.input-number-group .input-number,
.input-number-group .input-number-decrement,
.input-number-group .input-number-increment {
  border: 1px solid #cacaca;
  height: 40px;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  border-radius: 0;
}

.input-number-group .input-number-decrement,
.input-number-group .input-number-increment {
  display: inline-block;
  width: 40px;
  background: #e6e6e6;
  color: #0a0a0a;
  text-align: center;
  font-weight: bold;
  cursor: pointer;
  font-size: 2rem;
  font-weight: 400;
}

.input-number-group .input-number-decrement {
  margin-right: 0.3rem;
}

.input-number-group .input-number-increment {
  margin-left: 0.3rem;
}


</style>

@endsection


@section('content-general')
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ url('./') }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
                        <li><a href="javascript:void(0);">Carrito</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section">

        <div class="container">

            <div class="row">

                <div class="col-md-12">
                    <h2 class="titulo">Carrito</h2>
                    <hr class="amarillo">
                </div>

                <div class="section">
        
                    <div class="container">
        
                        <div class="row">
                            <!-- Order Details -->
                            <div class="col-md-12 order-details">
                                <div class="section-title text-center">
                                    <h3 class="title">Resumen</h3>
                                </div>
                              
                                @livewire("carrito")
                                

                            <div class="row">
        
                                <a href="checkout.php" class="primary-btn pull-right order-submit" style="margin: 0 30px;">Continuar</a>
                                </div>
                                    <div class="col-md-12">
                                        <p></p>
                                        <p></p>
                                    </div>
                                    <div class="clearfix">
                                        
                                    </div>
                                </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


