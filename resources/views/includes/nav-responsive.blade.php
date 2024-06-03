<nav>
    <!-- container -->
    <div class="container">
        <!-- responsive-nav -->
        <div class="container"> 
            <!-- responsive-nav -->
            <div id="responsive-nav">
                <!-- NAV -->
                <ul class="main-nav nav navbar-nav">
                    <li class="active"><a href="{{ url('/') }}">Inicio</a></li>
                    @foreach (get_categorias() as $item)
                    <li><a class="section-selector" data-type="{{ $item->id }}">{{ $item->nombre }}</a></li>
                    <li class="divider-vertical"></li>
                    @endforeach
                    <li><a href="{{ url("./contacto") }}">Contacto</a></li>
                    @if(oferta_primaria() == true)
                    <li><a  href="{{ url("./ofertas") }}" style="color: #FFB03D;">{{ get_title_oferta_ptimaria() }}</a></li>
                    @endif
                 
                    <li><a href="{{ url("./carrito") }}">Carrito</a></li>
                </ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>