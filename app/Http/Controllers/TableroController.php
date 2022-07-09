<?php

namespace App\Http\Controllers;

use App\Models\Tablero;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TableroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaTableros = Tablero::all();
        return $listaTableros;
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
                "color"         => "required",
                "titulo"         => "required",
                "visibilidad"         => "required",
                "usuario_id"         => "required"
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $objTablero = new Tablero($request->json()->all());
        $objTablero->save();

        return $objTablero;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tablero  $tablero
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objTablero = Tablero::find($id);

        if ($objTablero == null) {
            return response()->json(["message" => "Tablero no encontrado"], Response::HTTP_NOT_FOUND);
        }

        return $objTablero;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tablero  $tablero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $objTablero = Tablero::find($id);
        if ($objTablero == null) {
            return response()->json(["message" => "Tablero no encontrado"], Response::HTTP_NOT_FOUND);
        }

        if ($request->isMethod("put")) {
            $validator = Validator::make($request->all(), [
                    "titulo"         => "required",
                    "color"         => "required",
                    "visibilidad"         => "required",
                    "usuario_id"         => "required"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }
            $objTablero->update($request->json()->all());
        } elseif ($request->isMethod("patch")) {
            $objTablero->fill($request->json()->all());
            $objTablero->save();
        }

        return $objTablero;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tablero  $tablero
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $objTablero = Tablero::find($id);
        if ($objTablero == null) {
            return response()->json(["message" => "Tablero no encontrada"], Response::HTTP_NOT_FOUND);
        }
        $objTablero->delete();

        return [
            "res" => true
        ];
    }
    public function mostrarTablerosPublicos($id){
        $listTablerosPublicos = Tablero::with("user")->where("user.id","=",$id)->get();
        return $listTablerosPublicos;
    }


}
