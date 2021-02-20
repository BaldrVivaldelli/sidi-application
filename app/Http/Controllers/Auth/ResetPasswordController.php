<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\Validator;
use DB; 
use App\User;
use Auth;

class ResetPasswordController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;    
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }    
    public function resetPassword(Request $request)
    {
    
    //Validate input
    $validator = Validator::make($request->all(), [
        'email' => ['required', 'string', 'email', 'max:255'],
        'password' => [
            'required', 'string', 'min:8', 'max:12', 'confirmed',
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/', // must contain a special character
        ],
        'token' => 'required' ]);
        //check if payload is valid before moving on    
    if ($validator->fails()) {
        return redirect()->back()->withErrors( $validator )->withInput();
    }        
    $password = $request->password;
        
    // Validate the token
    // $tokenData = DB::table('password_resets')->where('token', $request->token)->first();
        
    // Redirect the user back to the password reset request form if the token is invalid
    // if (!$tokenData) return redirect('/password/reset')->withErrors(['La contraseña caduco, solicite una nueva']);
    
    $user = User::where('email', $request["email"])->first();
    // Redirect the user back if the email is invalid
    if (!$user) return redirect()->back()->withErrors(['email' => 'Email no registrado']);
    //Hash and update the new password
    $user->password = \Hash::make($password);
    $user->update(); //or $user->save();
    
    
    //login the user immediately they change password successfully
    Auth::login($user);

    //Delete the token
    DB::table('password_resets')->where('email', $user->email)->delete();

    //Send Email Reset Success Email    
    return redirect('/home');    

    }     

}
