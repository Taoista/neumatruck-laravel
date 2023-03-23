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
                    <h2 class="titulo">Pago</h2>
                    <hr class="amarillo">
                </div>
                
                <div class="section">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-7">
                            <table class="table">
                                <label for="">Productos</label>
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">IMG</th>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @php $cont = 1 @endphp
                                    @foreach ($productos AS $item)
                                    <tr>
                                        <th scope="row">{{ $cont ++ }}</th>
                                        <td><img style="width: 30px" src="{{ $item->img }}" alt=""></td>
                                        <td>{{ $item->codigo }}</td>
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->cantidad }}</td>
                                        <td>{{ set_money($item->p_venta * $item->cantidad) }}</td>
                                    </tr>
                                    @endforeach
                                
                                </tbody>
                              </table>

                              <table class="table table-bordered">
                                <label for="">Resumen de pago</label>
                              
                                <tbody>
                                    <tr>
                                        <th scope="row">NETO</th>
                                        <td>{{ format_money($data_compra->first()->neto) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">IVA</th>
                                        <td>{{ format_money($data_compra->first()->iva) }}</td>
                                    </tr>
                                    @if($data_compra->first()->delivery != 0)
                                    <tr>
                                        <th scope="row">DESPACHO</th>
                                        <td>{{  format_money($data_compra->first()->delivery)  }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th scope="row">TOTAL</th>
                                        <th scope="row">{{ format_money($data_compra->first()->total) }}</th>
                                    </tr>
                                </tbody>
                              </table>

                              <table class="table table-bordered">
                                <label for="">Detalle de compra</label>
                              
                                <tbody>
                                    <tr>
                                        <th scope="row">Nombre</th>
                                        <td>{{ strtoupper($data_compra->first()->nombre) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Rut</th>
                                        <td>{{ strtoupper($data_compra->first()->rut) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td>{{ strtolower($data_compra->first()->email) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">telefono</th>
                                        <td>{{ strtolower($data_compra->first()->telefono) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">nombre contacto</th>
                                        <td>{{ strtoupper($data_compra->first()->contacto) }}</td>
                                    </tr>
                                    @if($data_compra->first()->nota != "")
                                    <tr>
                                        <th scope="row">Nota</th>
                                        <td>{{ strtolower($data_compra->first()->nota) }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                              </table>

                            @if($data_compra->first()->id_ciudad != null)
                              <table class="table table-bordered">
                                <label for="">Detalle del delivery</label>
                              
                                <tbody>
                                    <tr>
                                        <th scope="row">Region</th>
                                        <td>{{ $data_ciudad->first()->region }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Ciudad</th>
                                        <td>{{ $data_ciudad->first()->ciudad }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">direccion</th>
                                        <td>{{ $data_compra->first()->direccion }}</td>
                                    </tr>
                                </tbody>
                              </table>
                            @endif
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
