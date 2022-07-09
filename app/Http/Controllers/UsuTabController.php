<?php

namespace App\Http\Controllers;

use App\Models\UsuTab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuTabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objUsuarioTablero = UsuTab::all();
        return $objUsuarioTablero;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                "usuario_id"         => "required",
                "tablero_id"       => "required"
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $objUsuarioTablero = new UsuTab($request->json()->all());
        $objUsuarioTablero->save();

        return $objUsuarioTablero;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UsuarioTablero  $usuarioTablero
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objUsuarioTablero = UsuTab::find($id);

        if ($objUsuarioTablero == null) {
            return response()->json(["message" => "Usuario no encontrada"], Response::HTTP_NOT_FOUND);
        }

        return $objUsuarioTablero;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UsuarioTablero  $usuarioTablero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $objUsuarioController = UsuTab::find($id);
        if ($objUsuarioController == null) {
            return response()->json(["message" => "Usuario no encontrada"], Response::HTTP_NOT_FOUND);
        }

        if ($request->isMethod("put")) {
            $validator = Validator::make($request->all(), [
                    "usuario_id"         => "required",
                    "tablero_id"       => "required"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }
            $objUsuarioController->update($request->json()->all());
        } elseif ($request->isMethod("patch")) {
            $objUsuarioController->fill($request->json()->all());
            $objUsuarioController->save();
        }

        return $objUsuarioController;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UsuarioTablero  $usuarioTablero
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsuarioTablero $id)
    {
        $objUsuarioTablero = UsuTab::find($id);
        if ($objUsuarioTablero == null) {
            return response()->json(["message" => "Usuario no encontrada"], Response::HTTP_NOT_FOUND);
        }
        $objUsuarioTablero->delete();

        return [
            "res" => true
        ];
    }
    public function showAsociado($id){
        $objTableroByUsuario = UsuTab::where("usuario_id", "=", $id )->get();

        if ($objTableroByUsuario == null) {
            return response()->json(["message" => "UsuarioTablero no encontrado"], Response::HTTP_NOT_FOUND);
        }

        return $objTableroByUsuario;
    }
}
