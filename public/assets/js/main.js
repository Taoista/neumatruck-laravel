/*-----------------------------------------------*/
/*          esconde togle                */
/*-----------------------------------------------*/

function mostrarTogle(){
	var demo = document.getElementById("responsive-nav").className;
			if(demo == ""){
				document.getElementById('responsive-nav').classList.toggle('active');
			}else{
				document.getElementById('responsive-nav').classList.toggle('active');
			}
}

// window.addEventListener('click', function(e){
// 	if (document.getElementById('responsive-nav').contains(e.target)){
//   	console.log("Clicked in Box");
//   } else{
// 		var demo = document.getElementById("responsive-nav").className;
// 		if(demo == "active"){
// 			document.getElementById('responsive-nav').classList.toggle('active');
// 		}
//   }
// })

/* buscardo r*/
function autocompletar(){
	const inputBusqueda = document.querySelector("#tipo-busqueda");
	let indexFocus = -1;

	inputBusqueda.addEventListener("input",function(){
		const tipoProducto = this.value;
		if(!tipoProducto) return false;
		cerrarLista();
		//crea la lista de suugerencias
		const divList = document.createElement("div");
		divList.setAttribute("id", this.id + '-lista-autocompletar');
		divList.setAttribute("class", this.id + ' lista-autocompletar-items');
		this.parentNode.appendChild(divList);

		// conexion a DB
		httpRequest('js/controller.php?tipo-item='+tipoProducto, function(){
			const arreglo = JSON.parse(this.responseText);

			// validar arreglar vs input
			if(arreglo.length == 0) return false
			arreglo.forEach(item=>{
				try{
					if(item.includes(tipoProducto) == true){
						const elementoLista = document.createElement('div');
						elementoLista.innerHTML = `<strong>${item}</strong>`;
					}
					}catch (error) {}
				});
				var i=0;
				for (i=0;i <= arreglo.length ;i++) {
					try{
							if(arreglo[i].toLowerCase().indexOf(tipoProducto.toLowerCase()) > -1){
								// console.log(arreglo[i]);
								var item = arreglo[i];
								console.log(item);
								const elementoLista = document.createElement('div');
								elementoLista.innerHTML = `<strong>${item}</strong>`;
								elementoLista.addEventListener('click', function(){
									inputBusqueda.value = this.innerText;
									cerrarLista();
									return false;
								});
								divList.appendChild(elementoLista);
							}
						}catch (error) {
					}
				}
		});

	});

	inputBusqueda.addEventListener("keydown",function(e){
		const divList = document.querySelector("#" + this.id + '-lista-autocompletar');
		let items;

		if(divList){
			items = divList.querySelectorAll('div');
			switch (e.keyCode) {
				case 40: // tecla de abajo
					indexFocus++;
					if(indexFocus > items.length-1) indexFocus = items.length - 1;
				break;

				case 38://arriba
					indexFocus--;
					if(indexFocus < 0) indexFocus = 0;
				break;

				case 13:// enter
					e.preventDefault();
					items[indexFocus].click();
					indexFocus = -1;
				break;

				default:
				break;
			}

			seleccionar(items, indexFocus);
			return false;

		}
	});

	document.addEventListener('click', function(){
		cerrarLista();
	});
}

function seleccionar(items, indexFocus){
	if(!items || indexFocus == -1) return false;
	items.forEach(x => {x.classList.remove('autocompletar-active')});
	items[indexFocus].classList.add('autocompletar-active');
}

function cerrarLista(){
	const items = document.querySelectorAll('.lista-autocompletar-items');
	items.forEach(item => {
		item.parentNode.removeChild(item);
	});
	indexFocus = -1;
}

function httpRequest(url,callback){
	const http = new XMLHttpRequest();
	http.open('GET',url);
	http.send();
	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			callback.apply(http);
		}
	}
}

// autocompletar();

(function($) {
	"use strict"

	// Mobile Nav toggle
	// $('.menu-toggle > a').on('click', function (e) {
	// 	e.preventDefault();
	// 	$('#responsive-nav').toggleClass('active');
	// })

	// Fix cart dropdown from closing
	$('.cart-dropdown').on('click', function (e) {
		e.stopPropagation();
	});

	/////////////////////////////////////////

	// Products Slick
	$('.products-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			autoplay: true,
			infinite: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
			responsive: [{
	        breakpoint: 991,
	        settings: {
	          slidesToShow: 2,
	          slidesToScroll: 1,
	        }
	      },
	      {
	        breakpoint: 480,
	        settings: {
	          slidesToShow: 1,
	          slidesToScroll: 1,
	        }
	      },
	    ]
		});
	});

	// Products Widget Slick
	$('.products-widget-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			infinite: true,
			autoplay: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
		});
	});

	/////////////////////////////////////////

	// Product Main img Slick
	$('#product-main-img').slick({
    infinite: true,
    speed: 300,
    dots: false,
    arrows: true,
    fade: true,
    asNavFor: '#product-imgs',
  });

	// Product imgs Slick
  $('#product-imgs').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    centerMode: true,
    focusOnSelect: true,
		centerPadding: 0,
		vertical: true,
    asNavFor: '#product-main-img',
		responsive: [{
        breakpoint: 991,
        settings: {
					vertical: false,
					arrows: false,
					dots: true,
        }
      },
    ]
  });

	// Product img zoom
	var zoomMainProduct = document.getElementById('product-main-img');
	if (zoomMainProduct) {
		$('#product-main-img .product-preview').zoom();
	}

	/////////////////////////////////////////

	// Input number
	$('.input-number').each(function() {
		var $this = $(this),
		$input = $this.find('input[type="number"]'),
		up = $this.find('.qty-up'),
		down = $this.find('.qty-down');

		down.on('click', function () {
			var value = parseInt($input.val()) - 1;
			value = value < 1 ? 1 : value;
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		})

		up.on('click', function () {
			var value = parseInt($input.val()) + 1;
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		})
	});

	var priceInputMax = document.getElementById('price-max'),
			priceInputMin = document.getElementById('price-min');

	priceInputMax.addEventListener('change', function(){
		updatePriceSlider($(this).parent() , this.value)
	});

	priceInputMin.addEventListener('change', function(){
		updatePriceSlider($(this).parent() , this.value)
	});

	function updatePriceSlider(elem , value) {
		if ( elem.hasClass('price-min') ) {
			console.log('min')
			priceSlider.noUiSlider.set([value, null]);
		} else if ( elem.hasClass('price-max')) {
			console.log('max')
			priceSlider.noUiSlider.set([null, value]);
		}
	}

	// Price Slider
	var priceSlider = document.getElementById('price-slider');
	if (priceSlider) {
		noUiSlider.create(priceSlider, {
			start: [1, 999],
			connect: true,
			step: 1,
			range: {
				'min': 1,
				'max': 999
			}
		});

		priceSlider.noUiSlider.on('update', function( values, handle ) {
			var value = values[handle];
			handle ? priceInputMax.value = value : priceInputMin.value = value
		});
	}

})(jQuery);
/*------------------------------------*/
/* continuar con el link en responsive*/
/*------------------------------------*/
function continuarCarritoResponsive(){
	var cantidad = document.getElementById("contenido-cantidad").innerHTML;
	if(cantidad > 0){
		location.href = "carro.php";
	}
}
