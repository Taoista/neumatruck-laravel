@extends('layouts.template_auxiliar')

@section('content-general')



    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="py-5 text-center">
          <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
          <h2>NEUMAEQUIPOS</h2>
          <p class="lead">Pago especial</p>
        </div>
  
        <div class="row">
          {{-- <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted">Your cart</span>
              <span class="badge badge-secondary badge-pill">3</span>
            </h4>
            <ul class="list-group mb-3">
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">Product name</h6>
                  <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$12</span>
              </li>
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">Second product</h6>
                  <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$8</span>
              </li>
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">Third item</h6>
                  <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$5</span>
              </li>
              <li class="list-group-item d-flex justify-content-between bg-light">
                <div class="text-success">
                  <h6 class="my-0">Promo code</h6>
                  <small>EXAMPLECODE</small>
                </div>
                <span class="text-success">-$5</span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span>Total (USD)</span>
                <strong>$20</strong>
              </li>
            </ul>
  
            <form class="card p-2">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Promo code">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-secondary">Redeem</button>
                </div>
              </div>
            </form>
          </div> --}}
          <div class="col-md-12 order-md-1">
            <h4 class="mb-3">Total a pagar {{ $pago }}</h4>
            <h4 class="mb-3">Billing address</h4>
            {{-- <form class="needs-validation" novalidate=""> --}}
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="firstName">Nombre</label>
                  <input type="text" class="form-control" id="firstName" placeholder="" value="" required="">
                  <div class="invalid-feedback">
                   
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="lastName">Apellido</label>
                  <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                  <div class="invalid-feedback">
                    
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="lastName">Rut</label>
                    <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                    <div class="invalid-feedback">
                    </div>
                  </div>
              </div>
  
              <div class="mb-3">
              
  
              <div class="mb-3">
                <label for="email">Email <span class="text-muted"></span></label>
                <input type="email" class="form-control" id="email" placeholder="correo@tucorreo.cl">
                <div class="invalid-feedback">

                </div>
              </div>
  
              <div class="mb-3">
                <label for="address">Direccion</label>
                <input type="text" class="form-control" id="address" placeholder="1234 Main St" required="">
                <div class="invalid-feedback">

                </div>
              </div>
  
              <div class="row">
               
              
              
              </div>
              <hr class="mb-4">
              {{-- <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="same-address">
                <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
              </div>
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="save-info">
                <label class="custom-control-label" for="save-info">Save this information for next time</label>
              </div> --}}
              <hr class="mb-4">
  
              <h4 class="mb-3">Pago</h4>
  
              
            
              <hr class="mb-4">
              <button class="btn btn-primary btn-lg btn-block" id="pgo-pago">Continuar con el pago</button>
            {{-- </form> --}}
          </div>
        </div>
  
        <footer class="my-5 pt-5 text-muted text-center text-small">
          <p class="mb-1">© 2017-2018 Company Name</p>
          <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Support</a></li>
          </ul>
        </footer>
      </div>
@endsection

@push('scripts')

      <script>
       
        const pagoFinal = document.querySelector('#pgo-pago').addEventListener('click', ()=>{
            alert('hola')
        })

      </script>

@endpush
