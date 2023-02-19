<div class="order-summary">

    @foreach ($productos AS $item)

    <div class="order-products">
        <div class="col-md-7 row">
            <div class="col-md-3 col-xs-4">
                <figure class="snip1205">
                    <img src="{{ $item->img }}" alt="{{ $item->nombre }}" class="img-responsive img-thumbnail">
                    <a href="ficha.php?idProducto=NTg3"></a>
                </figure>
            </div>

            <div class="col-md-9 col-xs-8">
                <p class="tit-prod2"> <a href="ficha.php?idProducto=NTg3">{{ $item->nombre }}</a></p>
                <p><small>Marca: {{ $item->marca }}<br>Código: {{ $item->codigo }}</small></p>
                <a>Precio {{ format_money($item->p_venta) }}</a><br>
                <small><a href="https://www.neumatruck.cl/carrito-accion.php?idpro=587&amp;accion=remove" class="red">Eliminar</a></small>
            </div>
        </div>

        <div class="col-md-2 col-xs-4">
            <div class="input-group input-number-group">
                <div class="input-group-button">
                  <span class="input-number-decrement">-</span>
                </div>
                <input class="input-number" type="text" disabled value="{{ $item->cantidad }}" min="1" max="{{ $item->stock }}">
                <div class="input-group-button">
                  <span class="input-number-increment">+</span>
                </div>
              </div>
        </div>

        <div class="col-md-3 col-xs-7 quita15r">
            <br class="visible-xs">
            <span class="precio pull-right" ><strong style="font-size:15px">{{ format_money($item->p_venta) }}</strong></span><br>
        </div>
        <div class="clearfix"></div><hr>
    </div>

    @endforeach


    <div class="order-col">
        <div style="padding: 0 15px;"><strong>SUBTOTAL NETO</strong></div>
        <div style="padding: 0 30px;"><strong>$ 1.996.607</strong></div>
    </div>
    <div class="order-col">
        <div style="padding: 0 15px;"><strong>IVA (19%)</strong></div>
        <div style="padding: 0 30px;"><strong>$ 379.355</strong></div>
    </div>
    <div class="order-col">
        <div style="padding: 0 15px;"><strong>TOTAL</strong></div>
        <div id="total_carro" style="padding: 0 30px;"><strong class="order-total"> $ 2.375.962</strong></div>
    </div>

</div>

@push('scripts')
<script>

$('.input-number-increment').click(function() {
  var $input = $(this).parents('.input-number-group').find('.input-number');
  var val = parseInt($input.val(), 10);
  $input.val(val + 1);
});

$('.input-number-decrement').click(function() {
  var $input = $(this).parents('.input-number-group').find('.input-number');
  var val = parseInt($input.val(), 10);
//   val = val == 1 ? 1 ? val;
    var nuevo = val == 1 ? 1 : val - 1; 
  $input.val(nuevo);
})
</script>
@endpush