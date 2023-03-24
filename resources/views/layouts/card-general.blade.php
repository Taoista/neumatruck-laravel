{{-- <div class="col-md-4 col-xs-6">
    <div class="product"><a href="ficha.php?idProducto=NDY4">
            <div class="product-img"><img src="{{ $item->img }}">
                @if($item->oferta == true)
                    @if($controller->state_oferta($item->id) == true)
                    <div class="product-label-oferta"><span class="new">OFERTAS </span></div>
                    @endif
                @endif
                <div class="product-label">
                    <span class="new">{{ strtoupper($item->marca) }}</span>
                </div>
            </div>
        </a>
        <div class="product-body"><br>
            <div class="product-label"></div>
            <h3 class="product-name"><a href="#">{{ $item->nombre }}</a></h3>
            @if($item->oferta == true)
                @if($controller->state_oferta($item->id) == true)
                <h4 class="product-price" style="color:red">OFERTA {{ "$ ".format_money(set_total($controller->value_oferta($item->id))) }}</h4>
                @endif
            @else
                <h4 class="product-price">{{ "$ ".format_money(set_total($item->p_venta)) }}</h4>
            @endif
            <p style="color:red;margin-top:0px;margin-bottom:0px">Precio Lista <del>578.000</del>
                </p><span>COD:{{ $item->codigo }}</span><br><span> Stock: {{ $item->stock }}</span>
        </div>
        @if($item->stock > 2)
        <div class="add-to-cart"><button class="add-to-cart-btn agregacarro" ><i class="fa fa-shopping-cart"></i>Agregar Al Carro</button></div>
        @else
        <div class="add-to-cart"><button class="add-to-cart-btn2">Ver2</button></div>
        @endif
    </div>
</div> --}}
