<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ListaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objLista = Lista::all();
        return $objLista;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Lista|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                "nombre"         => "required",
                "orden"       => "required",
                "tablero_id"         => "required"
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $objLista = new Lista($request->json()->all());
        $objLista->save();

        return $objLista;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objLista = Lista::find($id);

        if ($objLista == null) {
            return response()->json(["message" => "Lista no encontrada"], Response::HTTP_NOT_FOUND);
        }

        return $objLista;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $objLista = Lista::find($id);
        if ($objLista == null) {
            return response()->json(["message" => "Tarjeta no encontrada"], Response::HTTP_NOT_FOUND);
        }

        if ($request->isMethod("put")) {
            $validator = Validator::make($request->all(), [
                    "nombre"         => "required",
                    "orden"       => "required",
                    "tablero_id"         => "required"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }
            $objLista->update($request->json()->all());
        } elseif ($request->isMethod("patch")) {
            $objLista->fill($request->json()->all());
            $objLista->save();
        }

        return $objLista;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objLista = Lista::find($id);
        if ($objLista == null) {
            return response()->json(["message" => "Lista no encontrada"], Response::HTTP_NOT_FOUND);
        }
        $objLista->delete();

        return [
            "res" => true
        ];
    }
    public function listaDeListasPorTablero($id)
    {
        $objListaDeListaPorTablero = lista::where("tablero_id", "=", $id )->orderBy('orden','asc')->get();

        if ($objListaDeListaPorTablero == null) {
            return response()->json(["message" => "Tablero no encontrado"], Response::HTTP_NOT_FOUND);
        }

        return $objListaDeListaPorTablero;
    }

    public  function CanDeListasPorTablero($id)
    {
        $objListaDeListaPorTablero = lista::where("tablero_id", "=", $id )->count();

        if ($objListaDeListaPorTablero == null) {
            return response()->json(["message" => "Tablero no encontrado"], Response::HTTP_NOT_FOUND);
        }

        return $objListaDeListaPorTablero;
    }

}
