@extends('layouts.template')

@section('content-general')



    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ url('./') }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
                        <li><a href="javascript:void(0);">Producto</a></li>
                        <li><a href="javascript:void(0);">{{ strtoupper($data->nombre) }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section">

        <div class="container">

            <div class="row">

                <div class="section">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <div id="product-main-img" class="slick-initialized slick-slider">
                                    <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 458px;">
                                        <div class="product-preview slick-slide slick-current slick-active" style="background: url(&quot;../../img/img2.png&quot;) 0% 0% / cover no-repeat; min-height: 300px; width: 418px; position: relative; left: 0px; top: 0px; z-index: 999; opacity: 1; overflow: hidden;" data-slick-index="0" aria-hidden="false" tabindex="0">
                                        <img src="{{ $data->img }}" alt="215/75 R17.5 16PR TR-685">
                                        <img role="presentation" src="{{ $data->img }}" class="zoomImg" style="position: absolute; top: -1.91268px; left: -75.7225px; opacity: 0; width: 500px; height: 500px; border: medium none; max-width: none; max-height: none;"></div></div></div>
                                </div>
                                <small>* las imágenes pueden ser referenciales.</small>
                            </div>
                            <div class="col-md-7">
                                <div class="product-details">
                                    <h2 class="product-name">{{ $data->nombre }}</h2>
                                    <div>
                                        {{-- * oferta --}}
                                        @if($data->oferta == true)
                                            @if($controller->state_oferta($data->id) == true)
                                                <h3 class="product-price"> {{ set_money($controller->value_oferta($data->id)) }}
                                                <del class="product-old-price">{{ set_money($data->p_venta) }}</del>
                                                </h3>
                                            @else
                                            <h3 class="product-price">{{ set_money($data->p_venta) }}</h3>
                                            @endif
                                        {{-- * normal --}}
                                        @else
                                            <h3 class="product-price">{{ set_money($data->p_venta) }}</h3>
                                        @endif

                                        @if($data->oferta == true)
                                            @if($controller->state_oferta($data->id) == true)
                                                <h5 class=" lbl-ferta">{{ $controller->get_title_oferta($data->id) }} </h5>
                                            @endif
                                        @endif
                                        <ul class="product-links" style="margin-top: 20px;">
                                            <li>Stock:</li>
                                            <li>{{ $data->stock }}</li>
                                            <li>Stock sujeto a cambios sin previo aviso </li>
                                        </ul>
                                        <ul class="product-links" style="margin-top: 20px;">
                                            <li>Categoria:</li>
                                            <li>{{ $data->tipo }}</li>
                                        </ul>
                                        <ul class="product-links" style="margin-top: 0px;">
                                            <li>Marca:</li>
                                            <li>{{ strtoupper($data->marca) }}</li>
                                        </ul>
                                        <ul class="product-links" style="margin-top: 0px;">
                                            <li>Código:</li>
                                            <li>{{ $data->codigo }}</li>
                                        </ul>
                                            <ul class="product-links" style="margin-top: 0px;">
                                            @if($data->id_aplicacion != 0)
                                            <li>Aplicacion: {{ $data->aplicacion }}</li> <br>
                                            <li> <img src="{{ asset('assets/img/aplicacion').'/'.$data->id_aplicacion.'.svg' }}" alt="" style="width:100px"></li>
                                            @endif
                                        </ul>
                                        @if($data->estado == true AND $data->stock > min_stock())
                                        <ul>
                                            <li>
                                                <br>
                                                <div class="add-to-cart">
                                                    @livewire("card.button-add", ["id_producto" => $data->id])
                                                </div>
                                            </li>
                                        </ul>
                                        @else
                                        <br>
                                        <div class="add-to-cart">
											<button class="add-to-cart-btn2">Consulta Stock</button>
										</div>
                                         @endif
                                        <br><br>
                                    </div>

                                    <hr>
                                    <ul class="product-links">
                                        <li>Compartir:</li>
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div id="product-tab">
                                    <ul class="tab-nav">
                                        <li class="active"><a data-toggle="tab" href="#tab1">Información</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="tab1" class="tab-pane fade in active">
                                            <div class="row">
                                                <div class="col-md-12">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Aro</th>
                                                            <th class="fuentenormal"></th>
                                                            <th>Descripción</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Medida</th>
                                                            <th class="fuentenormal">{{ $data->medidas }}</th>
                                                            <th>
                                                                {{ $descripcion }}
                                                            </th>
                                                        </tr>
                                                        <tr>


                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>
@endsection
