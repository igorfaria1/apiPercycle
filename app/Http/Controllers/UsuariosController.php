<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Validator;

class UsuariosController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = User::all();
        return $this->sendResponse($usuario->toArray(), 'Usuarios listados com sucesso.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validar os dados
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'dt_nascimento' => 'required|date',
        ]);


        // Se a validação falhar
        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());       
        }


        // Salvar no banco de dados
        $usuario = new User;
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->dt_nascimento = $request->dt_nascimento;
        $usuario->save();


        return $this->sendResponse($usuario->toArray(), 'Usuario criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::find($id);

        if (is_null($usuario)) {
            return $this->sendError('Usuario não encontrado.');
        }


        return $this->sendResponse($usuario->toArray(), 'Usuario encontrado com sucesso');
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
        // Validar os dados
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => 'email',
            'dt_nascimento' => 'date',
        ]);


        // Se a validação falhar
        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());       
        }

        $usuario = User::find($id);

        // Salvar no banco de dados
        if ($request->has('name')) { 
            $usuario->name = $request->name;

        } if ($request->has('email')) {
            $usuario->email = $request->email;

        } if ($request->has('password')) {
            $usuario->password = Hash::make($request->password);

        } if ($request->has('dt_nascimento')) {
            $usuario->dt_nascimento = $request->dt_nascimento;
        }

        $usuario->save();


        return $this->sendResponse($usuario->toArray(), 'Usuario alterado com sucesso.');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = User::find($id);

        $usuario->delete();

        return $this->sendResponse($usuario->toArray(), 'Usuario deletado com sucesso.');
    }
}
