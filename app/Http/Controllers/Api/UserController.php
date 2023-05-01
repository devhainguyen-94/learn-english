<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use PHPUnit\Exception;
use Illuminate\Support\Facades\Hash;
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

    public function createClass(Request $request)
    {

        try {
            $class = ClassModel::where('name', $request->classname)->first();
            if (!$class) {
                $class = ClassModel::create([
                    'name' => $request->classname,
                ]);
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Create success',
                ]);
            }
            return response()->json([
                'status_code' => 500,
                'error' => 'Class is exist',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => $e,
            ]);
        }

    }

    public function updateClass(Request $request, $id)
    {
        try {
            $class = ClassModel::find($id);
            if ($class) {
                $class->name = $request->class_name;
                $class->save();
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Update success',
                ]);
            }
            return response()->json([
                'status_code' => 500,
                'message' => 'Class is not exist'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage(),
            ]);
        }

    }

    public function destroy($id)
    {
        try {
           $result =  ClassModel::find($id);
           if($result){
               ClassModel::destroy($id);
               return response()->json([
                   'status_code' => 200,
                   'message' => "Delete success",
               ]);
           }
            return response()->json([
                'status_code' => 500,
                'message' => "Class is not exist",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Create User
     */
    public function createUser(Request $request){
        try {
        $user = User::where('user_name', $request->username)->first();
        if(!$user){
            $result = User::create([
                'user_name' => $request->username,
                'role'=> $request->role,
                'password' => Hash::make($request->password)
            ]);
            if($result){
                return response()->json([
                    'status_code' => 200,
                    'message' => "Create User success",
                ]);
            }
            return response()->json([
                'status_code' => 500,
                'message' => "Create User fail",
            ]);
        }
            return response()->json([
                'status_code' => 500,
                'message' => "User name is exist",
            ]);
        }catch (Exception $e){
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getUser(){
        try{
            $user =  Auth::user();
            return response()->json([
                'status_code' => 200,
                'data' =>$user
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'status_code' => 500,
                'message' =>$e->getMessage(),
            ]);
        }

    }
    public function getAllClass(){
        try{
            $allClass = ClassModel::all();
            return response()->json([
                'status_code' => 200,
                'data' =>$allClass
            ]);
        }
        catch (\Exception $e){
            return response()->json([
                'status_code' => 500,
                'message' =>$e->getMessage(),
            ]);
        }
    }
}
