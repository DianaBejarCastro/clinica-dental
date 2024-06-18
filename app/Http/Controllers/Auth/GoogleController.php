<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
class GoogleController extends Controller
{
      /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        
        try {
            $user = Socialite::driver('google')->user();
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
           $patientRole = Role::where('name', 'patient')->first();
           if ($patientRole) {
               $existingUser->roles()->attach($patientRole);
           }
       }

            
          // Autenticar al usuario
          Auth::login($existingUser, true);
 

        // Redirigir a la página de inicio
        return redirect('dashboard');
    }    
 
}
