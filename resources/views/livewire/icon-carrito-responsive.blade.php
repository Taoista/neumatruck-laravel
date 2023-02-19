
<div class="header-ctn">

    <div class="dropdown carrito-togle" style="position:absolute;left:5px" x-data="componente_carrito()" @click="demo()">
        <a href="carro.php" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <i class="fa fa-shopping-cart" style="font-size:40px;"></i>
            <div id="contenido-cantidad" class="qty">{{ $carrito }}</div>
        </a>
    </div>

    <div class="menu-toggle">
        <a href="#" onclick="mostrarTogle()">
            <i class="fa fa-bars"></i>
            <span>Menu</span>
        </a>
    </div>
</div>

@push("scripts")

<script>
    function componente_carrito(){
        return {
            demo(){
                window.location.href = "{{ url('/') }}/"+'carrito'
            }
        }
    }
</script>

@endpush