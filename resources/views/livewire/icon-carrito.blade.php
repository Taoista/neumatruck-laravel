<div x-data="componente_carrito_normal()"  @click="redireccion()">
    <a href="{{ url('./carrito') }}" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-shopping-cart" style="font-size:40px;"></i>
        <div class="qty">{{ $carrito }}</div>
    </a>
</div>


    @push("scripts")

        <script>
            function componente_carrito_normal(){
                return {
                    redireccion(){
                        window.location.href = "{{ url('/') }}/"+'carrito'
                        // alert("hola mundo")
                    }
                }
            }
        </script>
    
    @endpush