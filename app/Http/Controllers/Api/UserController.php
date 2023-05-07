<?php

namespace App\Http\Controllers\Api;

use App\Models\CardDetailGroup;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use PHPUnit\Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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
            $class = ClassModel::where('name', $request['class-name'])->first();
            if (!$class) {
                $class = ClassModel::create([
                    'name' => $request['class-name'],
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

    public function deleteClass($id)
    {
        try {
            $result = ClassModel::find($id);
            if ($result) {
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

    public function getAllClass()
    {
        try {
            $allClass = ClassModel::all();
            return response()->json([
                'status_code' => 200,
                'data' => $allClass
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Create User
     */
    public function createUser(Request $request)
    {
        try {
            $user = User::where('user_name', $request['user-name'])->first();
            if (!$user) {
                $result = User::create([
                    'user_name' => $request['user-name'],
                    'role' => $request['role'],
                    'password' => Hash::make($request['password']),
                    'class_id' => $request['class-id'],
                    'password_not_encode' => $request['password']
                ]);
                if ($result) {
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
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getListUser($name = 0, $id = 0)
    {
        try {

            $listId = [];
            if($id != 0){
                $listId = explode(',',$id);
            }
            $user = User::with('userClass')->when($name != 0 ,function($q) use ($name){
               return $q->where('user_name', 'LIKE', '%'.$name.'%');
            })->when($listId != [] , function($q) use ($listId){
                foreach ($listId  as $id){
                    return  $q->orWhere('class_id',$id);
                }

            })->get();
            return response()->json([
                'status_code' => 200,
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage(),
            ]);
        }

    }

    public function updateUser(Request $request, $id)
    {
        try {
            $checkExist = count(User::where('user_name', $request['user-name'])->get());
            if (!$checkExist) {
                $user = User::find($id);
                if (isset($request['user-name'])) {
                    $user->user_name = $request['user-name'];
                }
                if (isset($request['password'])) {
                    $user->password = Hash::make($request['password']);
                    $user->password_not_encode = $request['password'];
                }
                if (isset($request['class-id'])) {
                    $user->class_id = $request['class-id'];
                }
                $user->save();
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Update user is success',
                ]);
            }
            return response()->json([
                'status_code' => 500,
                'message' => 'User Name is exist',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteUser($id)
    {
        try {
            $userCheck = User::find($id);
            if ($userCheck) {
                $result = User::delete($id);
                if ($result) {
                    return response()->json([
                        'status_code' => 200,
                        'message' => "Delete User success",
                    ]);
                }
                return response()->json([
                    'status_code' => 500,
                    'message' => "Delete is Failure",
                ]);

            }
            return response()->json([
                'status_code' => 500,
                'message' => "User is not exist",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

}
