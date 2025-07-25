<div>
    <div  x-data="demo_demo()" x-init="pipo()">
        <div class="product slick-slide" data-slick-index="5" aria-hidden="true" tabindex="-1" style="width: 263px;">
            {{-- <div class="product-img"><a href="{{ url('./ficha').'/'.$item->id }}" tabindex="-1"><img src="{{ $item->img }}"> --}}
            <div class="product-img"><a href="{{ url('./producto').'/'.$item->codigo }}" tabindex="-1"><img src="{{ $item->img }}">
                    @if($item->oferta == true)
                        @if($controller->state_oferta($item->id) == true)
                        <div class="product-label-oferta"><span class="new">{{ $controller->get_title_oferta($item->id) }}  </span></div>
                        @endif
                    @endif
                    <div class="product-label">
                        <span class="new">{{ strtoupper($item->marca) }}</span>
                    </div>
                </div>
            </a>
            <div class="product-body"><br>
                <div class="product-label"></div>
                <h3 class="product-name"><a href="{{ url('./producto').'/'.$item->codigo }}">{{ $item->nombre }}</a></h3>
                @if($item->oferta == true)
                    @if($controller->state_oferta($item->id) == true)
                        <h4 class="product-price" style="color:red">OFERTA {{ "$ ".format_money(set_total($controller->value_oferta($item->id))) }}  C/IVA</h4>
                    @else
                        <h4 class="product-price">{{ "$ ".format_money(set_total($item->p_venta)) }} C/IVA</h4>
                    @endif
                @else
                    <h4 class="product-price">{{ "$ ".format_money(set_total($item->p_venta)) }} C/IVA</h4>
                @endif
                <p style="color:red;margin-top:0px;margin-bottom:0px">Precio Lista <del>{{ "$ ".format_money(set_total($item->p_sistema)) }}  </del>
                 {{-- @if($item->stock >= 100)
                    </p><span>COD:{{ $item->codigo }}</span><br><span> Stock: +100</span>
                @else
                    </p><span>COD:{{ $item->codigo }}</span><br><span> Stock: {{ $item->stock }}</span>
                @endif --}}
            </div>
            @if($item->stock > 2)
            <div class="add-to-cart" wire:click="add_producto('{{ $item->id }}')" wire:loading.remove><button  class="add-to-cart-btn agregacarro"><i class="fa fa-shopping-cart"></i>Agregar Al Carro</button></div>
            <div class="add-to-cart" wire:loading wire:target="add_producto">
                <button class="add-to-cart-btn agregacarro" style="background-color: #FFF;
                                                                    padding-left: 95px;
                                                                    padding-right: 95px;
                                                                    color: #FFB03D;
                                                                    border-color: #FFB03D;
                                                                    font-size: 13px;">
                    <img style="width:20px" src="{{ asset('assets/img/loading.svg') }}" alt="">  </button></div>
            @else
            <div class="add-to-cart"><button class="add-to-cart-btn2" rel="href_envio(">Ver</button></div>
            @endif
        </div>
    </div>

</div>


@push("scripts")

<div x-data="card_componente()" x-init="demo()" class="modal fade" id="mi_modal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span><span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Agrega tu correo</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding:15px">
                    <label for="" style="color:red; display:none; text-align:center" id="lbl-error">Debe agregar un email valido para continuar</label>
                    <input @keydown.enter="add_card('{{ $item->id }}')" id="email-session-{{ $item->id }}" type="text" class="form-control" placeholder="Email"><br>
                    <button @click="add_card('{{ $item->id }}')" type="button" class="btn btn-default center-block">Continuar</button>
                </div>
            </div>

        </div>
    </div>
</div>


    <script>


        document.addEventListener("livewire:load", function(){

            let id_modal;

            window.addEventListener("open_modal", (e) => {
                id_modal = event.detail.id;
                $('#mi_modal-'+id_modal).modal('show');
            });

            window.addEventListener("save_producto", (e) => {
                Swal.fire('Producto','Producto fue agregado correctamente','success')
            });

            window.addEventListener("close_modal", (e) => {
                id_modal = event.detail.id;
                $('#mi_modal-'+id_modal).modal('hide');
            });


        })


        function demo_demo(){
            return {
                pipo(){
                    // alert("demo alpinejs")
                },
                select_product(codigo){
                    const redirect = `${_Url}producto/${codigo}`
                    window.location.href = redirect
                }
            }
        }

        function card_componente(){
            return {
                demo(){
                    // alert("comopnente alpinejs")
                },
                add_card(id){
                    const email = document.querySelector("#email-session-"+id).value;
                    if(email == ""){
                        Swal.fire('Email','Debe Agregar un email para continuar','error')
                        return false;
                    }

                    if(validador_email.test(email) ==  false){
                        Swal.fire('Email','El email no es valido','error')
                        return false
                    }

                    @this.add_card(id, email)
                },
             }
        }


    </script>
@endpush
