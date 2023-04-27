<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *     description="This is an example API",
 *     version="1.0.0",
 *     title="Example API"
 * )
 */
class Controller extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Get token for login",
     *     description="Returns information about the current user if the request is authenticated",
     *     @OA\Response(
     *         response=200,
     *         description="Everything OK"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Access Denied"
     *     )
     * )
*/
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
