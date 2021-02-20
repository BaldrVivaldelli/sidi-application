<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Socialite;
use App\User;
use Illuminate\Http\Request;
use DB;
use App\Quotation;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $loginPath ='/login';
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function logout(Request $request){
        Auth::logout();
        return redirect('/login');
    }
    public function redirectToProvider(){
        return  Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
        $authUser = $this->findOrCreateUser($user, 'google_id');
      
        if($authUser){            
            Auth::login($authUser,true);
            return redirect("/home");
        }else{
            return redirect('/login')->withErrors(['Usuario ya registrado']);
        }
    }
    public function findOrCreateUser($user, $provider){
        $authUser = User::where('email', $user->email)->first();
        //solo se le permite la autorizacion por google una vez dado de alta
        if($authUser && $authUser->tipoLogeo == 'google'){
            return $authUser;
        //se devuelve no autorizado si el usuario se registro manualmente por el sistema
        }else if ($authUser && $authUser->tipoLogeo != 'google'){
            return false;
        }else{
            //se da de alta si no existe el usuario directamente
            $auxName = explode(' ',$user->name);
            DB::table('users')->insert([
                 'name' =>  $auxName[0],
                 'lastname' => $auxName[1],
                 'email' => $user->email,
                 'user' => $user->email,
                 'password'=> $user->token,
                 'google_id' => $user->id,
                 'id_rol' => '1',
                 'id_estado' => '2',
                 'tipoLogeo' => 'google',
                 'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            // return false;

            $authUser = User::where('google_id', $user->id)->first();
            return $authUser;
            // Auth::login($authUser,true);
            // return redirect("/home");
        }
    }
    public function redirectTo(){
        return '/home';
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
