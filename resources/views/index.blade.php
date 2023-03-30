@extends('layouts.template')


@section('content-general')


    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
          <li data-target="#myCarousel" data-slide-to="3"></li>
          <li data-target="#myCarousel" data-slide-to="4"></li>
          <li data-target="#myCarousel" data-slide-to="5"></li>
          <li data-target="#myCarousel" data-slide-to="6"></li>
          <li data-target="#myCarousel" data-slide-to="7"></li>
          <li data-target="#myCarousel" data-slide-to="8"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            @foreach ($banners as $item )
            <div class="item {{ $item->activo == 1 ? 'active' : '' }}">
                @if($item->redireccion == "#")
                    <img src="{{ asset($item->img) }}" alt="{{ $item->title }}">
                @else
                    <a href="{{ url($item->redireccion) }}"><img src="{{ asset($item->img) }}" alt="{{ $item->title }}"></a>
                @endif
            </div>
            @endforeach
          {{-- <div class="item">
            <img src="{{ asset('assets/img/banner/ban2.webp') }}" alt="Chicago">
          </div>
          <div class="item">
            <img src="{{ asset('assets/img/banner/ban3.webp') }}" alt="New York">
          </div>
          <div class="item">
            <img src="{{ asset('assets/img/banner/ban4.webp') }}" alt="Los Angeles">
          </div>
          <div class="item">
            <img src="{{ asset('assets/img/banner/ban5.webp') }}" alt="Chicago">
          </div>
          <div class="item">
            <img src="{{ asset('assets/img/banner/ban6.webp') }}" alt="New York">
          </div>
          <div class="item">
            <img src="{{ asset('assets/img/banner/ban7.webp') }}" alt="New York">
          </div>
          <div class="item">
            <img src="{{ asset('assets/img/banner/ban8.webp') }}" alt="New York">
          </div> --}}
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Nuestras Marcas</h3>
                        <hr class="amarillo">
                    </div>
                </div>
                <!-- /section title -->
                <div class="col-md-12">
                    <section class="customer-logos slider">

                        @foreach($marcas as $item)
                        <div class="slide" style="width: 120px; margin:0 7px;">
                            <a href="{{ url("./category-brand").'/'.$item->id }}" class="">
                                <img style="width:100%;height:auto;" src="{{ asset('assets/img').'/'.$item->id.'.svg' }}" alt="">
                            </a>
                        </div>
                        @endforeach

                    </section>
                    <br>
                    <hr class="amarillo">
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>


    <div>
        <div class="section index-section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- section title -->
                    <div class="col-md-12">
                        <div class="section-title">
                            <h3 class="title">Camión y Bus</h3>
                            <hr class="amarillo">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">

                            <section class="responsive">
                                @foreach($camion_bus AS $item)
                                    @livewire("card.card-index", ["id_producto" => $item->id, key($item->id)])
                                @endforeach
                            </section>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h3 class="title">OTR / INDUSTRIAL</h3>
                            <hr class="amarillo">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <section class="responsive">
                                @foreach($otr AS $item)
                                    @livewire("card.card-index", ["id_producto" => $item->id, key($item->id)])
                                @endforeach
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h3 class="title">AGRÍCOLA </h3>
                            <hr class="amarillo">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <section class="responsive">
                            @foreach($agricola AS $item)
                                @livewire("card.card-index", ["id_producto" => $item->id, key($item->id)])
                            @endforeach
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('content-script')
<script>
    $(document).ready(function(){
        $('.customer-logos').slick({
            slidesToShow: 8,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2500,
            arrows: false,
            variableWidth: true,
            dots: false,
            pauseOnHover: false,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 520,
                settings: {
                    slidesToShow: 3
                }
            }]
        });
    });

// * carga de las imagenes sldier
$('.slick-slider').on('init', (event, slick, currentSlide) => {
  let slideIndex = slick.currentSlide;
  let slidesLength = slick.slideCount;
})




$('.responsive').slick({
  dots: true,
  infinite: true,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 4,
  variableWidth: true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 2,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }

  ]
});


    </script>
@endsection
