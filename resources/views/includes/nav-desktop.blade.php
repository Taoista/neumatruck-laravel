<nav class="navbar navbar-default"
style="border-color: transparent; background-color:transparent; border-top: 1px solid #fff; ">
<div class="container-fluid">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav nav-justified navbar-nav">
            {{-- ? ofertas primaria debe controlar si se muestra o nos --}}
            @if(oferta_primaria() == true)
              

                @for ($i = 0; $i < count(get_ofertas()); $i++)
                    <li>
                        <a style="{{ model_css(get_ofertas()[$i]['color_1'], get_ofertas()[$i]['color_2'], get_ofertas()[$i]['color_3']) }}" href="{{ url("./ofertas-seccion").'/'.base64_encode(get_ofertas()[$i]['id']).'/'.str_replace(' ', '-', get_ofertas()[$i]['nombre']); }}">{{ strtoupper(get_ofertas()[$i]['nombre']) }} </a>
                    </li>
                @endfor

            @endif
            @foreach (get_categorias() as $item)
            <li><a class="section-selector" data-type="{{ $item->id }}" href="#">{{ $item->nombre }}</a></li>
            <li class="divider-vertical"></li>
            @endforeach
            <li><a href="{{ url("./contacto") }}">Contacto</a></li>
        </ul>
    </div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>