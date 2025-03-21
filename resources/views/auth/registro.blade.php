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
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="text-center mb-3">
              <a href="#!">
                <!--<img src="https://www.itsolutionstuff.com/assets/images/footer-logo-2.png" alt="BootstrapBrain Logo" width="250">-->
              </a>
            </div>
            <!--<h2 class="fs-6 fw-normal text-center text-secondary mb-4">Sign up to your account</h2>-->
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                @if(session('error'))
                  <div class="alert alert-danger" role="alert">
                      {{ session('error') }}
                  </div>
                @endif

                <div class="row gy-2 overflow-hidden">
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="name@example.com" required>
                      <label for="name" class="form-label">{{ __('Nombre') }}</label>
                    </div>
                    @error('name')
                          <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" required>
                      <label for="email" class="form-label">{{ __('Correo') }}</label>
                    </div>
                    @error('email')
                          <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="" placeholder="Password" required>
                      <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                      <ul class="list-unstyled mt-2">
                          <li id="length" class="text-danger">❌ Mínimo 8 caracteres</li>
                          <li id="lowercase" class="text-danger">❌ Al menos una letra minúscula</li>
                          <li id="uppercase" class="text-danger">❌ Al menos una letra mayúscula</li>
                          <li id="number" class="text-danger">❌ Al menos un número</li>
                          <li id="special" class="text-danger">❌ Al menos un carácter especial (@$!%*?&#)</li>
                      </ul>
                    </div>
                    @error('password')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" value="" placeholder="password_confirmation" required>
                      <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }}</label>
                    </div>
                    @error('password_confirmation')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="g-recaptcha mb-4" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                  <div class="col-12">
                    <div class="d-grid my-3">
                      <button class="btn btn-primary btn-lg" type="submit">{{ __('Registrarse') }}</button>
                    </div>
                  </div>
                  <div class="col-12">
                    <p class="m-0 text-secondary text-center">Ya tienes una cuenta? <a href="{{ route('login') }}" class="link-primary text-decoration-none">Ingresa</a></p>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Script para validación en tiempo real -->
<script>
    document.getElementById('password').addEventListener('input', function () {
        let password = this.value;
        
        document.getElementById('length').className = password.length >= 8 ? 'text-success' : 'text-danger';
        document.getElementById('length').innerHTML = password.length >= 8 ? '✅ Mínimo 8 caracteres' : '❌ Mínimo 8 caracteres';

        document.getElementById('lowercase').className = /[a-z]/.test(password) ? 'text-success' : 'text-danger';
        document.getElementById('lowercase').innerHTML = /[a-z]/.test(password) ? '✅ Al menos una letra minúscula' : '❌ Al menos una letra minúscula';

        document.getElementById('uppercase').className = /[A-Z]/.test(password) ? 'text-success' : 'text-danger';
        document.getElementById('uppercase').innerHTML = /[A-Z]/.test(password) ? '✅ Al menos una letra mayúscula' : '❌ Al menos una letra mayúscula';

        document.getElementById('number').className = /[0-9]/.test(password) ? 'text-success' : 'text-danger';
        document.getElementById('number').innerHTML = /[0-9]/.test(password) ? '✅ Al menos un número' : '❌ Al menos un número';

        document.getElementById('special').className = /[@$!%*?&#]/.test(password) ? 'text-success' : 'text-danger';
        document.getElementById('special').innerHTML = /[@$!%*?&#]/.test(password) ? '✅ Al menos un carácter especial (@$!%*?&#)' : '❌ Al menos un carácter especial (@$!%*?&#)';
    });
</script>
</body>
</html>
