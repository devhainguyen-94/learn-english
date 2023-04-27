<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClassModels;

/**
 * @OA\Post(
 * path="/api/login",
 * summary="Sign in",
 * description="Login by user name , password",
 * operationId="authLogin",
 * tags={"auth"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"user_name","password"},
 *       @OA\Property(property="user_name", type="string", format="user_name", example="admin"),
 *       @OA\Property(property="password", type="string", format="password", example="12345678"),
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
 *        )
 *     )
 * )
 */
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    public function createClass(Request $request){
        $class = ClassModel::where('name', $request->username)->first();

        if(!$class){
            $class = ClassModel::create([
                'name' => $request->classname,
            ]);
}

    }
    
}
