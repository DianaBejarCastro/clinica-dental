<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
      /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback()
    {
        
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
           return redirect('/login')->withErrors(['msg' => 'Error al autenticarse con Google. Por favor, inténtelo de nuevo.']);
        }
       
       // Comprobar si el usuario ya existe en la base de datos
       $existingUser = User::where('email', $user->email)->first();
 
       // Si el usuario no existe, crearlo
       if (!$existingUser) {
           $existingUser = User::create([
               'name' => $user->name,
               'email' => $user->email,
               'password' => bcrypt('password'), // Genera una contraseña aleatoria
           ]);
       }

            
          // Autenticar al usuario
          Auth::login($existingUser, true);
 

        // Redirigir a la página de inicio
        return redirect('dashboard');
    } 
}
