<div id="newsletter" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="newsletter">
                    <p>Si deseas ser parte de nuestro circulo y recibir nuestro <strong>NEWSLETTER</strong></p>
                    <form>
                        <input wire:model="email_newslatter" class="input" type="email" name="email_newsletter" placeholder="Dirección de Email" >
                        <button class="newsletter-btn" type="submit" wire:click.prevent="insert_newslatter"><i class="fa fa-envelope"></i> Suscribete</button>
                    </form>
                    <ul class="newsletter-follow">
                        <li><a target="_blank" href="https://www.facebook.com/neumatruck.cl/"><i
                                    class="fa fa-facebook"></i></a></li>
                        <li><a target="_blank"
                                href="https://web.whatsapp.com/send?phone=56954104080&amp;text=Estoy%20interesado%20en%20sus%20productos"><i
                                    class="fa fa-whatsapp"></i></a></li>
                        <li><a target="_blank" href="https://www.instagram.com/neumatruck.cl/"><i
                                    class="fa fa-instagram"></i></a></li>
                        <li><a target="_blank" href="mailto:contacto@neumatruck.cl"><i
                                    class="fa fa-envelope-o"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push("scripts")
    <script>
         document.addEventListener("livewire:load", function(){


                window.addEventListener("error_email", (e) => {
                    Swal.fire('Email','Debe agregar un email para continuar','error')
                });
                window.addEventListener("email_inserted", (e) => {
                    Swal.fire('Email','Ingresado Correctamente','success')
                });


        })
    </script>
@endpush