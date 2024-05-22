<div>
    <div class="section" x-data="component_tbk()" x-init="demo()">
        <div class="container">
            <div class="row">
            {{-- <form class="checkout" > --}}
                <div class="col-md-7">
                    @if(state_production() == false)
                    <button wire:click="full_data">Llenar datos</button>
                    @endif

                    <div class="billing-details">
                        <div class="section-title">+
                            <img src="" alt="">
                            <h3 class="title">Datos de Contacto / Facturacion </h3>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="rut_empresa" wire:model="rut_empresa" placeholder="Rut" maxlength="12" pattern="\d{3,8}-[\d|kK]{1}" required="">
                        </div>

                        <div class="form-group">
                            <input class="input" type="text" name="razon_social" wire:model="razon_social" placeholder="Nombre" required="">
                        </div>

                        <div class="form-group">
                            <input class="input" type="email" name="email" wire:model="email" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <input class="input" type="text" name="fono" wire:model="fono" placeholder="Fono" required="">
                        </div>

                        <div class="form-group">
                            <input class="input" type="text" name="contacto" wire:model="contacto" placeholder="Nombre Contacto" required="">
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" wire:model="selected_delivery" value="1" wire:click="chanche_delivery">
                            <label class="form-check-label" for="exampleRadios1">
                              Retiro Local
                            </label>
                          </div>

                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" wire:model="selected_delivery" value="2" wire:click="chanche_delivery">
                            <label class="form-check-label" for="exampleRadios2">
                              Despacho
                            </label>
                          </div>

                        <div class="form-group">
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1" @disabled($delivery_disabeled == true) wire:model="selected_region">
                                  <option value="0" selected>Region</option>
                                  @foreach ($regiones AS $item )
                                      <option value="{{ $item->id_region }}">{{ strtoupper($item->region) }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1" @disabled($city_disabeled == true) wire:model="id_ciudad">
                                  <option value="0" selected>Ciudad</option>
                                    @foreach ($city AS $item )
                                        <option value="{{ $item->id }}">{{ strtoupper($item->ciudad) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <input class="input" type="text" name="direccion" wire:model="direccion" placeholder="Dirección de despacho"  @disabled($delivery_disabeled == true)>
                        </div>
                        {{-- * boton para calcular el envio --}}
                        {{-- @if($delivery_disabeled == false)
                        <div class="form-group">
                                <button type="button" class="btn btn-info" wire:click="add_despacho" wire:loading.remove>Calcular Despacho</button>
                                <button type="button" class="btn btn-secondary" wire:loading wire:target="add_despacho">
                                <img style="width: 20px" src="{{ asset('assets/img/loading.svg') }}" alt="">Cargando</button>
                        </div>

                        @endif --}}
                        @if($selected_delivery == "2")
                        <strong style="color: #ffb03d; font-size:15px">Verificar costo de envio con el vendedor</strong>
                        @endif
                    </div>

                    <div class="order-notes">
                        <textarea class="input" name="mensaje" wire:model="mensaje" placeholder="Mensaje"></textarea>
                    </div>

                </div>

                <div class="col-md-5 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">Resumen</h3>
                    </div>

                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>PRODUCTOS</strong></div>
                            <div><strong>TOTAL</strong></div>
                        </div>
                        <div class="order-products">
                            @foreach ($productos AS $item )
                            <div class="order-col">
                                <div> {{ $item->cantidad }} x {{ strtoupper($item->nombre) }} </div>
                                @if($item->oferta == true)
                                    @if($controller->state_oferta($item->id) == true)
                                    <div>{{ set_money($controller->value_oferta($item->id)  * $item->cantidad) }}</div>
                                    @else
                                    <div>{{ set_money($item->p_venta * $item->cantidad)  }}</div>
                                    @endif
                                @else
                                <div>{{ set_money($item->p_venta * $item->cantidad)  }}</div>
                                @endif
                            </div>
                            @endforeach

                        </div>

                        <hr>
                        <div class="order-col">
                            <div style="padding: 0 0;"><strong>Subtotal</strong></div>
                            <div style="padding: 0 0;"><strong class="" style="font-size: 15px"> {{ '$ '.format_money($neto) }}</strong></div>
                        </div>

                        <div class="order-col">
                            <div style="padding: 0 0;"><strong>Iva</strong></div>
                            <div style="padding: 0 0;"><strong class="" style="font-size: 15px"> {{ '$ '.format_money($iva) }}</strong></div>
                        </div>
                        @if($selected_delivery == '2')
                        <div class="order-col">
                            <div style="padding: 0 0;"><strong>Despacho</strong></div>
                            <div style="padding: 0 0;"><strong class="" style="font-size: 15px">{{ "$ ".format_money($val_despacho) }}</strong></div>
                        </div>
                        @endif
                        <div class="order-col">
                            <div style="padding: 0 0;"><strong>TOTAL</strong></div>
                            <div style="padding: 0 0;"><strong class="order-total"> {{ "$ ".format_money($total_pago) }}</strong></div>
                        </div>
                    </div>
                    {{-- @if($state_pay == true) --}}
                    <button class="primary-btn btn-block order-submit btsubmit" wire:click="state_final_pay" wire:loading.remove>Pagar</button><br>
                    {{-- @endif --}}
                    <button class="primary-btn btn-block" wire:loading  wire:target="state_final_pay" style="color:black" ><img style='width:20px' src="{{ asset('assets/img/loading-black.svg') }}" alt="">Cargando...</button><br>
                    <div class="text-center">
                        <p style="color:#ffb03d;"><i class="fa fa-truck"></i></p>
                        {{-- <p>* Despacho gratis en toda RM sobre 150.000.-</p> --}}
                        <hr>
                        {{-- <p> ● Despacho a otras regiones consultar con verdedor Para más información revisar <a href="{{ url('./politicas-despacho') }}" style="color:#ffb03d;font-weight: bold;">Política de Despacho</a>.</p> --}}
                        <p> ● Retiro Clientes Monto Mínimo <strong  style="color:#ffb03d; font-size:15px">$ 100.000 neto</strong> </p>
                        <p> ● Despacho RM monto mínimo  <strong style="color:#ffb03d; font-size:15px">$ 150.000 neto</strong> </p>
                        <p> ● Despacho Regiones monto mínimo <strong  style="color:#ffb03d; font-size:15px">$ 200.000 neto</strong> </p>
                        <p> ● * Para más información revisar <a href="{{ url('./politicas-despacho') }}" style="color:#ffb03d;font-weight: bold;">Política de Despacho</a>.  </p>

                    </div>
                </div>

                <div class="col-md-12">
                </div>
            {{-- </form> --}}
        </div>
    </div>
    </div>

</div>

@push("scripts")

    <script>

        function component_tbk(){
            return {
                demo(){
                    // alert("comopnente de alpinejs")
                }
            }
        }

        document.addEventListener("livewire:load", function(){


            window.addEventListener("kill_swal", (e) => {
                Swall.close();
            });

            window.addEventListener("error_region", (e) => {
                Swal.fire('Delivery','Debe seleccionar region y ciudad cara continuar','error')
            });

            window.addEventListener("lading_pantalla", (e) => {
                Swal.fire({
                    html:'<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
                    title: 'Cargando..',
                    showCloseButton: false,
                    showCancelButton: false,
                    focusConfirm: false,
                    showConfirmButton:false,
                    })
                $(".swal2-modal").css('background-color', 'rgba(0, 0, 0, 0.0)');
                $(".swal2-title").css("color","white");
            });

            window.addEventListener("empty_direccion", (e) => {
                Swal.fire('Delivery','Falta direccion para continuar','error')
            });

            window.addEventListener("empty_campos", (e) => {
                Swal.fire('Delivery','Debe llenar los compos para continuar','error')
            });

            window.addEventListener("monto_minimo", (e) => {
                const  monto_minimo = event.detail.lbl_monto_mostrar
                Swal.fire('Monto Minimo',`Para realizar este pedido debe seleccionar forma de despacho`,'error')
            });

            window.addEventListener("error_monto_minimo", (e) => {
                const  monto_minimo = event.detail.monto_minimo
                Swal.fire('Monto Minimo',`el monto minimo debe de ser ${monto_minimo} neto`,'error')
            });

            

            window.addEventListener("loading_tbk", (e) => {
                const  id_compra = event.detail.id_compra


                const parameters = {"id_compra" : id_compra}
                console.log(parameters)
                // console.log($('meta[name="csrf-token"]').attr('content'))

                new Promise((resolve, reject) =>{
                    $.ajax({
                        data: parameters,
                        url:  _Url+"api/iniciar_compra",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend:function(){
                        },
                        success:function(response){
                            console.log('experando')
                            console.log(response)
                            resolve(response);
                        }
                    })
                }).then(res => {
                    console.log("resolviendo")
                    window.location.href = res;
                })
            });




        })
    </script>

@endpush
