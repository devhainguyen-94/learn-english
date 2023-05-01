<?php

namespace App\Http\Controllers\Api;
use App\Models\GroupCard;
use App\Http\Controllers\Controller;
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
 * tags={"CardDetail"},
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
class CardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function createGroupCard(Request $request){
        try {
             $result = GroupCard::create([
                'group_name' => $request['group-name'],
            ]);
            if($result){
                return response()->json([
                    'status_code' => 200,
                    'message' => "create group card success"
                ]);
            }
            return response()->json([
                'status_code' => 500,
                'message' => "Group is exist"
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function createCardDetail(Request $request){
        try{
        $type = $request->type;
        $result = '';
        switch ($type){
            case 1:
                break;
            case 2 :
                break;
            case 3 :
                break;
            default:
                break;
        }
        if($result){
            return response()->json([
                'status_code' => 200,
                'message' => 'Create Card Success'
            ]);
        }
        }
        catch (\Exception $e){
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

}
