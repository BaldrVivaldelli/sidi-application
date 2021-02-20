<?php

namespace App\Http\Controllers;

use App\Regions;
use File;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Storage;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\User;
use Redirect;

use Illuminate\Support\Facades\Auth;
use Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $dataUsers = DB::table('users')->get();


        $users = array();
        foreach ($dataUsers as $aux) {
            $user = array();
            $user['name'] = $aux->name;
            $user['email'] = $aux->email;
            $auxRol = DB::table('roles')->where('id', $aux->id_rol)->first();            
            $user['permisos'] = $auxRol->descripcion;
            $auxState = DB::table('estados')->where('id', $aux->id_estado)->first();
            $user['estado'] = $auxState->estado;
            array_push($users, $user);
        }

        $roles = array();
        $dataRoles = DB::table('roles')->get();
        foreach ($dataRoles as $auxRol) {
            $rol = $auxRol->descripcion;            
            array_push($roles, $rol);
        }


        $estados = array();
        $dataEstados = DB::table('estados')->get();
        foreach ($dataEstados as $auxEstado) {
            // $estado = array();
            $estado = $auxEstado->estado;
            // dd($estado);
            // $estado['descripcion'] = $estado;
            array_push($estados, $estado);
        }                
        // dd($user['permisos']);
        return view('/users', ['users' => $users, 'roles'=> $roles, 'estados'=> $dataEstados]);
    }

    
    public function changestate(Request $request)
    {
        

        $user = User::where('email', '=', $request['email'])->first();            

        if(Auth::user()->id !== $user->id && $user->email !== "admin@admin.com"){                    
            
            if($user->id_estado == 1){
                $user->id_estado = 2;
            }else{        
                $user->id_estado = 1;
            }
            $user->save();
        }
        $dataUsers = DB::table('users')->get();

        $users = array();

        foreach ($dataUsers as $aux) {
            $user = array();
            $user['name'] = $aux->name;
            $user['email'] = $aux->email;
            $auxRol = DB::table('estados')->where('id', $aux->id_rol)->first();
            $user['permisos'] = $auxRol->estado;
            $auxState = DB::table('estados')->where('id', $aux->id_estado)->first();
            $user['estado'] = $auxState->estado;
            array_push($users, $user);
        }
        $roles = array();
        $dataRoles = DB::table('estados')->get();
        foreach ($dataRoles as $auxRol) {
            $rol = array();
            $rol['descripcion'] = $auxRol->estado;
            array_push($roles, $rol);
        }
        Log::info('Se cambio el estado del usuario');
        return redirect("/users");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $request->validate([
            'demo-email' => ['required'],
            'demo-password' => 'required|min:8|max:12',
            'email'=> 'email|unique:users,email',
            'demo-password-validate' => ['same:demo-password'],
        ]);

        $result = DB::table('users')->where('email',$request['demo-email'])->first();
        if($result == null){

        
        //creo un usuario
        $user = new User();
        $user->user = $request['demo-name'];
        $user->name = $request['demo-name'];
        $user->lastname = $request['demo-name'];
        $user->id_rol = 1;
        $user->id_estado = 1;
        $user->email = $request['demo-email'];
        $user->password = bcrypt($request['demo-password']);
        
        Log::info('Se creo el  usuario');
        $user->save();
        return redirect('/home');
        }else{
            return Redirect::back()->withErrors(['email must be unique']);
        }
    }

    
    public function  changeUserRol(Request $request)
    {           
        $nuevoRol = DB::table('roles')->where('descripcion',$request['rol'])->first();    
        $user = User::where('email', $request['email'])-> first();
        if(Auth::user()->id !== $user->id && $user->email !== "admin@admin.com"){                
            $user->id_rol = $nuevoRol->rol;                
            $user->save();
        }
        Log::info('Se cambio el  usuario');
        return redirect("/users");
    }

    public function changePasswordIndex(){
        return view('profile');
    }
    public function changePassword(Request $request)
    {

        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'password' => [
                'required','confirmed','min:8','max:12',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],            
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);
        Log::info('Se cambio la contraseña del usuario');
        return redirect()->back()->withSuccess('contraseña modificada exitosamente');;
    }

    public function deleteUser(Request $request)
    {

        $user = User::where('email', '=', $request['email'])->first();
        if(Auth::user()->id !== $user->id && $user->email !== "admin@admin.com"){                
            $user->delete();
        }

        $dataUsers = DB::table('users')->get();

        $users = array();

        foreach ($dataUsers as $aux) {
            $user = array();
            $user['name'] = $aux->name;
            $user['email'] = $aux->email;
            $auxRol = DB::table('estados')->where('id', $aux->id_rol)->first();
            $user['permisos'] = $auxRol->estado;
            array_push($users, $user);
        }

        $roles = array();
        $dataRoles = DB::table('estados')->get();
        foreach ($dataRoles as $auxRol) {
            $rol = array();
            $rol['descripcion'] = $auxRol->estado;
            array_push($roles, $rol);
        }

        Log::info('Se borro el usuario');
        return redirect("/users");
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Regions  $regions
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function edit(Regions $regions)
    {
        //
    }
    public function getAddRegionData(Regions $regions)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Regions $regions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regions $regions)
    {
        //
    }
}
