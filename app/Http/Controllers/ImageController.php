<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @method static find($id)
 */
class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objImage = Image::all();
        return $objImage;
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
                'archivo'         => "required",
                "tarea_id"       => "required"
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }


        $file      = $request->file('archivo');
        $extension = $file->getClientOriginalExtension();
        $last = Image::all()->lastInsertId();
        $lasts = $last +1;
        $file->move(public_path().'/fotos/', "$lasts.$extension");
        $objPersona=new Image();
        $objPersona->tarea_id= $request->json()->getInt("tarea_id" );
        $objPersona->url="http://localhost:8000/fotos/$lasts.$extension";
        $objPersona->save();

        return response()->json([
            "message" => "Imagen subida correctamente"
        ]);




        return $objPersona;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $usuarioTablero
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objImage = Image::find($id);

        if ($objImage == null) {
            return response()->json(["message" => "Usuario no encontrada"], Response::HTTP_NOT_FOUND);
        }

        return $objImage;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $usuarioTablero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $objUsuarioController = ImageController::find($id);
        if ($objUsuarioController == null) {
            return response()->json(["message" => "Usuario no encontrada"], Response::HTTP_NOT_FOUND);
        }

        if ($request->isMethod("put")) {
            $validator = Validator::make($request->all(), [
                    "url"         => "required",
                    "tarea_id"       => "required"
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
     * @param  \App\Models\Image  $usuarioTablero
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $id)
    {
        $objImage = ImageController::find($id);
        if ($objImage == null) {
            return response()->json(["message" => "Usuario no encontrada"], Response::HTTP_NOT_FOUND);
        }
        $objImage->delete();

        return [
            "res" => true
        ];
    }
    public function showAsociado($id){
        $objTableroByUsuario = ImageController::where("tarea_id", "=", $id )->get();

        if ($objTableroByUsuario == null) {
            return response()->json(["message" => "Image no encontrado"], Response::HTTP_NOT_FOUND);
        }

        return $objTableroByUsuario;
    }
}
