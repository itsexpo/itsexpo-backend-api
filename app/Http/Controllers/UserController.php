<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\Me\MeService;
use App\Core\Application\Service\LoginUser\LoginUserRequest;
use App\Core\Application\Service\LoginUser\LoginUserService;
use App\Core\Application\Service\RegisterUser\RegisterUserRequest;
use App\Core\Application\Service\RegisterUser\RegisterUserService;
use App\Core\Application\Service\UserVerification\UserVerificationRequest;
use App\Core\Application\Service\UserVerification\UserVerificationService;

class UserController extends Controller
{
    /**
     * @OA\Tag(
     *   name="Authentication",
     *   description="API Endpoints of User"
     * )
    *      @OA\Post(
    *          path="/login_user",
    *          tags={"Authentication"},
    *          description="Login",
    *          @OA\RequestBody(
    *              required=true,
    *              @OA\JsonContent(
    *                  required={"email", "password"},
    *                  @OA\Property(property="email", type="string", example="admin@itsexpo.com"),
    *                  @OA\Property(property="password", type="password", example="1234567"),
    *              )
    *          ),
    *
    *          @OA\Response(
    *              response="200",
    *              description="Success",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="status", type="boolean"),
    *                  @OA\Property(property="data", type="object",
    *                       @OA\Property(property="token", type="string"),
    *                   ),
    *               )
    *         ),
    *          @OA\Response(
    *              response="401",
    *              description="Unauthorized",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="status", type="boolean", example="false"),
    *                  @OA\Property(property="code", type="string", example="1001"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    *   )
     */
   
    public function createUser(Request $request, RegisterUserService $service): JsonResponse
    {
        $request->validate([
            'email' => 'unique:user,email|email',
            'password' => 'min:8|max:64|string',
            'name' => 'min:8|max:128|string',
            'no_telp' => 'min:10|max:15|string'
        ]);

        $input = new RegisterUserRequest(
            $request->input('email'),
            $request->input('no_telp'),
            $request->input('name'),
            $request->input('password')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Registrasi");
    }

    /**
     * @throws Exception
     */
    public function loginUser(Request $request, LoginUserService $service): JsonResponse
    {
        $input = new LoginUserRequest(
            $request->input('email'),
            $request->input('password')
        );
        $response = $service->execute($input);
        return $this->successWithData($response, "Berhasil Login");
    }

    /**
     * @throws Exception
     */
    public function userVerification(Request $request, UserVerificationService $service): JsonResponse
    {
        $input = new UserVerificationRequest(
            $request->input('email'),
            $request->input('token')
        );
        $service->execute($input);
        return $this->success("Berhasil Verifikasi User");
    }

    /**
     * @throws Exception
     */
    public function me(Request $request, MeService $service): JsonResponse
    {
        $response = $service->execute($request->get('account'));
        return $this->successWithData($response, "Berhasil Mengambil Data");
    }
}
