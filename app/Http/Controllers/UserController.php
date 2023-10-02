<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => [
                'users' => UserResource::collection(User::all())
            ]
        ]);
    }


    public function login(LoginRequest $request): JsonResponse
    {
        if(Auth::attempt($request->validated())){
            $user = Auth::user();
            $token = $user->createToken('Auth')->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'token' => $token
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Username or Password is wrong!'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $user = $request->validated();
        $data = User::create($user);
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => new UserResource($data)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $data = User::findOrFail(['id' => $id])->first();
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => new UserResource($data)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id)
    {

        try{
            User::findOrFail(['id' => $id]);
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
        }

        User::where('id', $id)->update([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Update Success',
            'data' => new UserResource(User::find($id))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try{
            User::findOrFail(['id' => $id]);
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
        }


        User::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Deleted Success'
        ]);
    }
}
