<!DOCTYPE html>
<html>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel 9 </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <style type="text/css">
    body{
      background: #F8F9FA;
    }
  </style>
</head>
<body>

<section class="bg-light py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm mt-5">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="text-center mb-3">
              <a href="#!">
                <!--<img src="https://www.itsolutionstuff.com/assets/images/footer-logo-2.png" alt="BootstrapBrain Logo" width="250">-->
              </a>
            </div>
            <!--<h2 class="fs-6 fw-normal text-center text-secondary mb-4">Sign in to your account</h2>-->
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                @if(session('error'))
                  <div class="alert alert-danger" role="alert">
                      {{ session('error') }}
                  </div>
                @endif

              <div class="row gy-2 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="nombre@ejemplo.com" required>
                    <label for="email" class="form-label">{{ __('Correo') }}</label>
                  </div>
                  @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="" placeholder="Password" required>
                    <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                  </div>
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="col-12">
                  <div class="d-flex gap-2 justify-content-between">
                    <div class="form-check">
                      <!--<input class="form-check-input" type="checkbox" value="" name="rememberMe" id="rememberMe">
                      <label class="form-check-label text-secondary" for="rememberMe">
                        Recordarme
                      </label>-->
                    </div>
                    <!--<a href="#!" class="link-primary text-decoration-none">{{ __('forgot password?') }}</a>-->
                  </div>
                </div>
                <div class="g-recaptcha mb-4" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                <div class="col-12">
                  <div class="d-grid my-3">
                    <button class="btn btn-primary btn-lg" type="submit">{{ __('Entrar') }}</button>
                  </div>
                </div>
                <div class="col-12">
                  <p class="m-0 text-secondary text-center">No tienes una cuenta? <a href="{{ route('register') }}" class="link-primary text-decoration-none">Registrate</a></p>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</section>

</body>
</html>

