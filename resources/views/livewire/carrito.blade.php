<div class="order-summary" x-data="element_component()" x-init="demo()">

    @foreach ($productos AS $item)

    <div class="order-products">
        <div class="col-md-7 row">
            <div class="col-md-3 col-xs-4">
                <figure class="snip1205">
                    <img src="{{ $item->img }}" alt="{{ $item->nombre }}" class="img-responsive img-thumbnail">
                    <a href="{{ url("./ficha").'/'.$item->id }}"></a>
                </figure>
            </div>

            <div class="col-md-9 col-xs-8">
                <p class="tit-prod2"> <a href="{{ url("./ficha").'/'.$item->id }}">{{ $item->nombre }}
                    @if($item->oferta == true)
                        @if($controller->state_oferta($item->id) == true)
                        <span style="color:red">OFERTA</span>
                        @endif
                    @endif
                </a></p>
                <p><small>Marca: {{ $item->marca }}<br>Código: {{ $item->codigo }}</small></p>
                <a>Precio {{ format_money($item->p_venta) }}</a><br>
                <button  @click="delete_item()" wire:click="delete_item('{{ $item->id }}')" > Eliminar</button>
            </div>
        </div>

        <div class="col-md-2 col-xs-4">
            <div class="input-group input-number-group">
                <div class="input-group-button" wire:click="rest_item('{{ $item->id }}')" @click="change_cantidad()">
                  <span class="input-number-decrement">-</span>
                </div>
                <input class="input-number" type="text" wire:model="list_cantidad.{{$item->id}}" disabled min="1" max="{{ $item->stock }}">
                <div class="input-group-button" wire:click="add_item('{{ $item->id }}')"  @click="change_cantidad()">
                  <span class="input-number-increment">+</span>
                </div>
              </div>
        </div>

        <div class="col-md-3 col-xs-7 quita15r">
            <br class="visible-xs">
            @if($item->oferta == true)
                @if($controller->state_oferta($item->id) == true)
                <span class="precio pull-right" ><strong style="font-size:15px">{{ format_money($controller->value_oferta($item->id)  * $item->cantidad) }}</strong></span><br>
                @endif
            @else
                <span class="precio pull-right" ><strong style="font-size:15px">{{ format_money($item->p_venta * $item->cantidad) }}</strong></span><br>
            @endif
        </div>
        <div class="clearfix"></div><hr>
    </div>

    @endforeach


    <div class="order-col">
        <div style="padding: 0 15px;"><strong>SUBTOTAL NETO</strong></div>
        <div style="padding: 0 30px;"><strong>{{ '$ '.format_money($sub_total) }}</strong></div>
    </div>
    <div class="order-col">
        <div style="padding: 0 15px;"><strong>IVA (19%)</strong></div>
        <div style="padding: 0 30px;"><strong>{{ '$ '.format_money($iva) }}</strong></div>
    </div>
    <div class="order-col">
        <div style="padding: 0 15px;"><strong>TOTAL</strong></div>
        <div id="total_carro" style="padding: 0 30px;"><strong class="order-total">{{ '$ '.format_money($iva + $sub_total) }}</strong></div>
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

function element_component(){
    return {
        demo(){
            // alert("demo alpinejs");
        },
        delete_item(){
            Swal.fire({
                html:'<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
                title: 'Eliminando..',
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: false,
                showConfirmButton:false,
            })
            $(".swal2-modal").css('background-color', 'rgba(0, 0, 0, 0.0)'); 
            $(".swal2-title").css("color","white"); 
        },
        change_cantidad(){
            Swal.fire({
                html:'<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
                title: 'Modificando..',
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: false,
                showConfirmButton:false,
            })
            $(".swal2-modal").css('background-color', 'rgba(0, 0, 0, 0.0)'); 
            $(".swal2-title").css("color","white"); 
        }
    }
}

document.addEventListener("livewire:load", function(){

    document.addEventListener('delete_item', e =>{
        Swal.fire(
            'Producto',
            'Producto Eliminado correctamente',
            'success'
        )
    })

    document.addEventListener('swal_close', e =>{
        Swal.close()
    })

    

});


</script>
@endpush