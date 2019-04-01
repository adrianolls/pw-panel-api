<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Controllers\Controller;
use App\Models\UserPending;
use App\Models\User;

class RegisterController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/v1/user/register",
     *     summary="Registra um usuário",
     *     operationId="register",
     *     tags={"users"},
     *     @OA\Parameter(
     *         name="login",
     *         in="query",
     *         description="Login da conta",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *         @OA\Parameter(
     *         name="nickname",
     *         in="query",
     *         description="Apelido do jogador",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="truename",
     *         in="query",
     *         description="Nome do usuário",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="E-mail do usuário",
     *         required=true,
     *        @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Senha do usuário",
     *         required=true,
     *        @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="repassword",
     *         in="query",
     *         description="Repetir senha do usuário",
     *         required=true,
     *        @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="terms",
     *         in="query",
     *         description="Termos de uso",
     *         required=true,
     *        @OA\Schema(
     *           type="boolean",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Conta é ativada ou dispara email de ativação",
     *     ),
     *  )
     */
    public function register(UserRegisterRequest $request)
    {
        $userPending = UserPending::createPendingUserFromRequest($request);
        if (!config('perfectworld.mailactivateuser', true)) {
            return $this->checkUpAndCreateUser($userPending);
        }
        return response()->json(['message' => 'activate your account in email'], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/user/activate/{code}",
     *     summary="Ativa a conta de um usuário",
     *     operationId="activateUser",
     *     tags={"users"},
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         description="Código de ativação de conta",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ativa um código enviado pelo email e gera uma nova conta no sistema",
     *     ),
     *  )
     */
    public function activateUser($code)
    {
        $userPending = UserPending::whereCode($code)->first();
        if (is_null($userPending)) {
            $result = [
                'error' => [
                    'invalidcode' => trans('custom.invalidcode')
                ]
            ];
            return response()->json($result, 422);
        }
        return $this->checkUpAndCreateUser($userPending);
    }

    /**
     * Check if UserPending is not invalid registration and create user
     */
    public function checkUpAndCreateUser(UserPending $userPending)
    {
        $usercheck = User::whereEmail($userPending->email)->first();
        if (!is_null($usercheck)) {
            return response()->json([
                'error' => [
                    'emailinuse' => trans('custom.emailinuse')
                ]
            ], 422);
        }
        $user = User::adduser($userPending);
        return $user;
    }
}
