<?php


namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use App\Mail\Pruebas;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration(): View
    {
        
        return view('auth.registro');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    


    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required' // Validar que el reCAPTCHA se haya enviado
        ]);

        // Validar reCAPTCHA con Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response')
        ]);

        $result = $response->json();

        if (!$result['success']) {
            return back()->withErrors(['captcha' => 'Verificación de reCAPTCHA fallida.']);
        }

        // Intento de autenticación
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user instanceof User) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['auth' => 'Error al autenticar.']);
            }

            // Generar OTP
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(5);
            $user->save();

            // Enviar OTP por email
            $this->sendOtp($user);

            return redirect()->route('verify.otp')->with('success', 'Código OTP enviado.');
        }

        return redirect()->route('login')->withErrors(['login' => 'Credenciales incorrectas.']);
    }

    /*public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Verificar si el usuario es una instancia de User
            if (!$user instanceof User) {
            return redirect()->route('login')->withErrors('Error al autenticar.');
            }

            //generar codigo otp
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(5);
            $user->save();
            // dd($user);
            //
            $this->sendOtp($user);

            //redirigir a la pantalla de verificacion
           return redirect()->route('verify.otp')->with('Succes', 'Codigo Enviado');
        }
  
        return redirect("login")->withError('Credenciales incorrectas.');
    }*/
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request): RedirectResponse
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $user = $this->create($data);
            
        Auth::login($user); 

        return redirect("login")->withSuccess('Has iniciado sesion correctamente');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('Ups, No tienes acceso');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    public function sendOtp($user)
    {
        /*Mail::raw("Tu codigo de verificacion es: {$user->otp}", function ($message) use ($user){
           $message->to($user->email)
                ->subject('codigo de verificacion'); 
        });*/
        $email = new Pruebas($user->otp);
        Mail::to($user->email)->send($email);
    }
    /*public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $user = Auth::user();
        // Verificar si el usuario es una instancia de User
        if (!$user instanceof User) {
            return redirect()->route('login')->withErrors('Error al autenticar.');
        }

        if ($user->otp == $request->otp && Carbon::now()->lessThan($user->otp_expires_at)) {
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            session(['2fa' => true]);
            //return redirect()->route('dashboard');
            return redirect("dashboard")->withSuccess('hola');
        }

        return back()->withErrors('Código incorrecto o expirado.');
    }*/
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        $user = Auth::user();

        // Verificar si el usuario es una instancia válida
        if (!$user instanceof User) {
            return redirect()->route('login')->withErrors(['auth' => 'Error al autenticar.']);
        }

        // Validar OTP y que no haya expirado
        if ($user->otp === $request->otp && Carbon::now()->lessThan($user->otp_expires_at)) {
            // Resetear OTP después de una verificación exitosa
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            session(['2fa' => true]);

            return redirect("dashboard")->with('success', 'OTP verificado correctamente.');
        }

        // Retornar error si el OTP es inválido o expiró
        return back()->withErrors(['otp' => 'Código incorrecto o expirado.']);
    }

}
