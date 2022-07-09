<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use App\Models\Tarea;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaTareas = Tarea::all();
        return $listaTareas;
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

                'lista_id'=> "required",
                "titulo"         => "required",
                "descripcion"       => "required",
                "vence"         => "required",
                "orden"         => "required",
                "estado"              =>"required",
                "usuario_id"         => "required"

            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $objTarea = new Tarea($request->json()->all());
        $objTarea->save();

        return $objTarea;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objTarea = Tarea::find($id);

        if ($objTarea == null) {
            return response()->json(["message" => "Tarea no encontrado"], Response::HTTP_NOT_FOUND);
        }

        return $objTarea;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarea  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $objTarea = Tarea::find($id);
        if ($objTarea == null) {
            return response()->json(["message" => "Tarea no encontrada"], Response::HTTP_NOT_FOUND);
        }

        if ($request->isMethod("put")) {
            $validator = Validator::make($request->all(), [
                    'lista_id'=> "required",
                    "titulo"         => "required",
                    "descripcion"       => "required",
                    "vence"         => "required",
                    "orden"         => "required",
                    "estado"              =>"required",
                    "usuario_id"         => "required"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }
            $objTarea->update($request->json()->all());
        } elseif ($request->isMethod("patch")) {
            $objTarea->fill($request->json()->all());
            $objTarea->save();
        }

        return $objTarea;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarea  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objTarea = Tarea::find($id);
        if ($objTarea == null) {
            return response()->json(["message" => "Tarea no encontrada"], Response::HTTP_NOT_FOUND);
        }
        $objTarea->delete();

        return [
            "res" => true
        ];
    }

    public function listaDeTareaPorListas($id)
    {
        $objListaDeListaPorTablero = tarea::where("lista_id", "=", $id )->orderBy('orden','asc')->get();

        if ($objListaDeListaPorTablero == null) {
            return response()->json(["message" => "Tablero no encontrado"], Response::HTTP_NOT_FOUND);
        }

        return $objListaDeListaPorTablero;
    }

    public  function CanDetareaPorTablero($id)
    {
        $objListaDeListaPorTablero = tarea::where("lista_id", "=", $id )->count();

        if ($objListaDeListaPorTablero == null) {
            return response()->json(["message" => "Tablero no encontrado"], Response::HTTP_NOT_FOUND);
        }

        return $objListaDeListaPorTablero;
    }

}
