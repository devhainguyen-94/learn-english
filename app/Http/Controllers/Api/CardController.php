<?php

namespace App\Http\Controllers\Api;

use App\Models\CardDetail;
use App\Models\GroupCard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;
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
    public function getListGroupCardByUser(){
        $userId = Auth::user()->id;

    }
    /**
     * Get list group card in admin
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListGroupCard($id){
        try {
            $listGroupCard = GroupCard::where('folder_id', $id)->get();
            return response()->json([
                'status_code' => 200,
                'data' => $listGroupCard
            ]);
        }
        catch (\Exception $e){
            return response()->json([
                'status_code' => 500,
                'message' => $e
            ]);
        }

    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function createGroupCard(Request $request)
    {
        try {
            $result = GroupCard::create([
                'group_name' => $request['group-name'],
                'folder_id' => $request['folder-id']
            ]);
            if ($result) {
                return response()->json([
                    'status_code' => 200,
                    'message' => "create group card success"
                ]);
            }
            return response()->json([
                'status_code' => 500,
                'message' => "Group is exist"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function createCardDetail(Request $request)
    {
        try {
            $type = $request->type;
            $result = '';
            switch ($type) {
                case 1:
                    $result = CardDetail::create([
                        'word' => $request['word'],
                        'means' => $request['means'],
                        'spelling' => $request['spelling'],
                        'word_type' => $request['word_type'],
                        'audio_link' => $request['audio_link'],
                        'example' => $request['example'],
                        'type' => $type,
                    ]);
                    break;
                case 2 :
                    $result = CardDetail::create([
                        'word' => $request['word'],
                        'means' => $request['means'],
                        'example' => $request['example'],
                        'type' => $type,
                    ]);
                    break;
                case 3 :
                    $result = CardDetail::create([
                        'word' => $request['word'],
                        'means' => $request['means'],
                        'type' => $type,
                    ]);
                    break;
                default:
                    break;
            }
            if ($result) {
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Create Card Success'
                ]);
            }
            return response()->json([
                'status_code' => 500,
                'message' => 'Create card is failure'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

}
