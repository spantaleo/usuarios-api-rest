<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Users;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $users = Users::all();
		 
		 return json_encode($users);
    }

	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'username'   => 'required',
			'nombre'     => 'required',
			'apellido'   => 'required',
            'email'      => 'required|email'
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return json_encode(array("error" => 1, "msg" => "Error en la validacion para guardar" ));
        } else {
            // store
            $user = new Users;
            $user->username     = $request->username;
            $user->email    = $request->email;
            $user->nombre 	= $request->nombre;
			$user->apellido = $request->apellido;
            $user->save();

            return json_encode(array("error" => 0, "msg" => "OK" ));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$user = Users::find($id);
        return json_encode($user);
    }


    public function search($searchTerm)
    {
		
		
		$patron = '/^[a-zA-Z]*$/';
        if(!preg_match($patron,$searchTerm)){
            return json_encode(array("error" => 1, "msg" => "Error en la validacion para actualizar" ));
        } else {
			$users = Users::query()
				   ->where('nombre', 'LIKE', "%{$searchTerm}%")
				   ->orWhere('apellido', 'LIKE', "%{$searchTerm}%")	
				   ->orWhere('username', 'LIKE', "%{$searchTerm}%")	
				   ->orWhere('email', 'LIKE', "%{$searchTerm}%") 
				   ->get();
		}		   
        return json_encode($users);
    }
	
	
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // validate
        $rules = array(
            'username'       => 'required',
			'nombre'         => 'required',
			'apellido'       => 'required',			
            'email'   	     => 'required|email',
           
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return json_encode(array("error" => 1, "msg" => "Error en la validacion para actualizar" ));
        } else {
            // store
            $user = Users::find($id);
            $user->username     = $request->username;
            $user->email    = $request->email;
            $user->nombre 	= $request->nombre;
			$user->apellido = $request->apellido;
            $user->save();

			return json_encode($user);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // delete
        $user = Users::find($id);
        $user->delete();

    }
}
