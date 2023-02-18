@extends('layouts.template')

@section('content-general')
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ url('./') }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
                        <li><a href="javascript:void(0);">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section">

        <div class="container">

            <div class="row">

                <div class="col-md-12">
                    <h2 class="titulo">Contacto</h2>
                    <hr class="amarillo">
                </div>


            </div>
        </div>
    </div>

    <div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="col-md-7">
					<form action="#" class="contact-form" enctype="application/x-www-form-urlencoded" method="post" siq_id="autopick_8977">
						<!-- Billing Details -->
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title">Datos</h3>
							</div>
							<div class="form-group">
								<input id="name" class="input" type="text" name="name" placeholder="Nombre" required="">
							</div>
							<div class="form-group">
								<input id="email" class="input" type="email" name="email" placeholder="Email" required="">
							</div>
							<div class="form-group">
								<input id="phone" class="input" type="phone" name="subject" placeholder="Telefono" maxlength="100" required="">
							</div>
							<div class="form-group">
								<input id="asunto" class="input" type="text" name="subject" placeholder="Asunto" maxlength="100" required="">
							</div>
							<div class="form-group">
								<textarea id="text-contac" class="input" name="message" placeholder="Mensaje"></textarea>
								<input type="hidden" name="enviado" value="enviado">
							</div>
						</div>
					
						

						
					</form>
					<br>

                    {{-- <div>
				
						<form id="form-img" action="./funciones/upload-photo.php" method="post" enctype="multipart/form-data" siq_id="autopick_8431">
							<label for="">Ingresar Imagen</label>
							 <input onchange="update_file()" id="img-photo" type="file" name="image" accept="image/*;capture=camera" data-buttontext="Your label here."><br>
							<!-- <button id="btn-envio" type="submit" class="btn btn-primary">Subir Imagen</button> -->
							<button id="btn-delete" onclick="delete_photo()" type="button" class="btn btn-danger" style="display:none">Eliminar</button>
						</form>
                    </div> --}}
							 
                    
					<form action="" siq_id="autopick_1532"><br>
						<button class="primary-btn order-submit" type="submit">Enviar Consulta </button>
					</form>

				</div>
               
				<!-- Order Details -->
				<div class="col-md-5">
					<div class="section-title text-center">
						<img src="{{ asset('assets/img/img_contacto.jpg') }}" class="img-responsive">
					</div>
				</div>
				<!-- /Order Details -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->

		<video id="video" autoplay="autoplay" class="video_container none"></video>

	</div>
@endsection

@section('content-script')
<script src="{{ asset('assets/js/contacto.js') }}"></script>
@endsection
