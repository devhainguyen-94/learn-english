<?php

namespace App\Http\Controllers\Api;

use App\Models\CardDetail;
use App\Models\CardDetailGroup;
use App\Models\GroupCard;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserLearnHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;
use Illuminate\Support\Facades\Hash;
use App\Models\UserLearnCard;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Helper\Constant;

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

    use HasFactory, Notifiable, HasApiTokens;

    public function getListGroupCardByUser()
    {
        try {
            $userId = Auth::user()->id;
            $user = User::find($userId);
            $listCard = [];
            $numberCardRemaining = 0;
            $allCardNew = 0;
            $time = UserLearnCard::where('user_id', $userId)->whereBetween('updated_at',
                [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
            )->avg('time_avg');
            $timeAVG = $time == null ? UserLearnCard::where('user_id', $userId)->avg('time_avg') : $time;
            $numberCardLearned = count(UserLearnCard::where('user_id', $userId)->whereColumn('updated_at', '>', 'created_at')->whereDate('updated_at', Carbon::today())->get());
            $totalTimeLearnedToday = UserLearnCard::where('user_id', $userId)->whereColumn('updated_at', '>', 'created_at')->whereDate('updated_at', Carbon::today())->sum('time_avg');
            foreach ($user->userGroup as $group) {
                $info = [];

                $numberCardRemaining += count(UserLearnCard::where('user_id', $userId)
                    ->where('group_id', $group->id)->where('time_remind', '<', Carbon::now())->get());
                $cardNew = UserLearnCard::where('user_id', $userId)->where('group_id', $group->id)->where('time_avg', 0)->get();
                $allCardNew += count($cardNew);
                $carPractive = UserLearnCard::where('user_id', $userId)
                    ->where('group_id', $group->id)->where('time_remind', '<', Carbon::now())->where('time_avg', '!=', 0)->get();
                $info['number_card_new'] = count($cardNew);
                $info['number_card_practice'] = count($carPractive);
                $info['group_info'] = $group;
                array_push($listCard, $info);
            }
            $data['list_card'] = $listCard;
            $totalCard = ($allCardNew * 3) + $numberCardRemaining;
            $data['remaining_info']['number_card_remaining'] = (int)$numberCardRemaining;
            $data['remaining_info']['time_remaining'] = $totalCard * $timeAVG;
            $data['learned_info']['number_card_learned'] = (int)$numberCardLearned;
            $data['learned_info']['all_time_learned'] = (int)$totalTimeLearnedToday;
            return response()->json([
                'status_code' => 200,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e
            ]);
        }


    }

    /**
     * Get list group card in admin
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListGroupCard($id)
    {
        try {
            $listGroupCard = GroupCard::where('folder_id', $id)->get();
            return response()->json([
                'status_code' => 200,
                'data' => $listGroupCard
            ]);
        } catch (\Exception $e) {
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

    public function updateGroupCard(Request $request, $id)
    {
        try {
            $groupCard = GroupCard::find($id);
            if (isset($request['group-name'])) {
                $checkExist = GroupCard::where('group_name', $request['group-name'])->count();
                if ($checkExist) {
                    return response()->json([
                        'status_code' => 500,
                        'message' => "Group Name is exist"
                    ]);
                }
                $groupCard->group_name = $request['group-name'];
            }
            if (isset($request['folder-id'])) {
                $groupCard->folder_id = $request['folder-id'];
            }
            $groupCard->save();
            return response()->json([
                'status_code' => 200,
                'message' => "Update group card success"
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteGroupCard($id)
    {
        try {
            $groupCard = GroupCard::find($id);
            $result = $groupCard->delete();
            if ($result) {
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Delete Group Card is success'
                ]);
            }
            return response()->json([
                'status_code' => 500,
                'message' => 'Delete Folder is failure'
            ]);
        } catch (\Exception $e) {
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

    private function assignUserForGroupCard($userId, $groupCardId, $type)
    {
        try {
            $checkExist = count(UserGroup::where('group_id', $groupCardId)->where('user_id')->where('type', $type)->get());
            if (!$checkExist) {
                UserGroup::created([
                    'user_id' => $userId,
                    'group_id' => $groupCardId,
                    'type' => $type,
                    'const' => 1
                ]);
                $listCardDetail = CardDetailGroup::where('group_id', $groupCardId)->get();
                foreach ($listCardDetail as $card) {
                    $checkUserLearnCardExist = UserLearnCard::where('user_id', $userId)->where('group_id', $groupCardId)
                        ->where('card_detail_id', $card->card_detail_id)->get();
                    if (!$checkUserLearnCardExist) {
                        UserLearnCard::created([
                            'user_id' => $userId,
                            'group_id' => $groupCardId,
                            'card_detail_id' => $card->card_detail_id,
                            'time_remind' => Carbon::now(),
                            'times' => 0
                        ]);
                    }
                }
            }

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function learnCard(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $userLearnCard = UserLearnCard::where('card_detail_id', $request['card_detail_id'])->where('group_id', $request['group-id'])
                ->where('user_id', $userId)->get();
            $userLearnHistory = (UserLearnHistory::where('user_learn_card_id', $userLearnCard->id)->whereDate('updated_at', Carbon::now())->get());
            if ($userLearnCard->const_q)
                if (count($userLearnHistory)) {
                    $userLearnHistory->time_learn++;
                    $userLearnHistory->save();
                } else {
                    UserLearnHistory::created([
                        'user_learn_card_id' => $userLearnCard->id,
                        'time_learn' => $request['time-learn']
                    ]);
                }
            if (($userLearnCard->const_q == null) &&
                ($request['type'] == Constant::TYPE_RELEARN || $request['type'] == Constant::TYPE_LEARN_HARD)) {
                $userLearnCard->time_learn = $request['time'] > 60 ? 60 : $request['time'];
                $userLearnCard->time_remind = $request['type'] == Constant::TYPE_RELEARN ? Carbon::now()->addMinute() : Carbon::now()->addMinutes(10);
                $userLearnCard->save();
            } else if ($userLearnCard->const_q == null && $request['type'] == Constant::TYPE_LEARN_GOOD) {
                $userLearnCard->const_hard_type = 10;
                $userLearnCard->const_good_type = 1;
                $userLearnCard->const_easy_type = 4;
                $userLearnCard->const_q = 0;
            }
            $userLearnCard->time_remind = $this->calculationTimeRemind($request['type'], $userLearnCard);
            $userLearnCard->save();
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }

    }

    private function calculationTimeRemind($type, UserLearnCard $userLearnCard)
    {
        switch ($type) {
            case 0 :
                return [
                    'const_q' => 0
                ];
                break;
            case 1 :

        }
    }

}
