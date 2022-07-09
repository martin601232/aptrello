<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->json()->all(), [
            "name" => ['required', 'string'],
            "email" => ['required', 'string'],
            "password" => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
        $user = User::create([
            "name" => $request->json("name"),
            "email" => $request->json("email"),
            "password" => bcrypt($request->json("password"))
        ]);
        return response()->json($user);
    }

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            return response()->json([
                "access_token" => $tokenResult->plainTextToken
            ]);
        } else {
            return response()->json([
                "message" => "Unauthenticated."
            ], 401);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        $listaPersonas = User::all();
       // Persona::where("user_id", "=", Auth::user()->id)->get();
        return $listaPersonas;
    }



    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return JsonResponse|Persona
     */
    public function show()
    {
        $objPersona = User::where("id", "=", Auth::user()->id)->get();

        if ($objPersona == null) {
            return response()->json(["message" => "Persona no encontrada"], Response::HTTP_NOT_FOUND);
        }

        return $objPersona;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Persona  $persona
     *
     * @return JsonResponse
     */

}


