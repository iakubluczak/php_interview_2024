<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthStrategyFactory;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $login = $request->input('login');
        $password = $request->input('password');

        $authStrategy = AuthStrategyFactory::createStrategy($login);

        if ($authStrategy && $authStrategy->authenticate($login, $password)) {
            return $this->generateSuccessResponse($login);
        }

        return $this->generateFailureResponse();
    }

    private function generateSuccessResponse(string $login): JsonResponse
    {
        $context = explode('_', $login)[0];

        $claims = [
            'sub' => $login,
            'context' => $context,
            'iat' => time(),
            'exp' => time() + 3600,
        ];

        $payload = JWTFactory::customClaims($claims)->make();
    
        $token = JWTAuth::encode($payload)->get();
        
        return response()->json([
            'status' => 'success',
            'token' => $token,
        ], Response::HTTP_OK);
    }

    private function generateFailureResponse(): JsonResponse
    {
        return response()->json([
            'status' => 'failure',
        ], Response::HTTP_UNAUTHORIZED);
    }
}
