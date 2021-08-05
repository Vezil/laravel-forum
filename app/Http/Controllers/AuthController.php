<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login', 'signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $token = JWTAuth::attempt($credentials);

        if ($token) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function signup(SignupRequest $request)
    {

        $userRole = Role::where('name', 'user')->first();

        $user = User::create($request->all());

        $user->roles()->attach($userRole);

        $userEmail = $request->all()['email'];

        $verification_code = Str::uuid()->toString();

        User::where('email', $userEmail)->update(['verification_code' => $verification_code]);

        MailController::sendSignupEmail($user->name, $user->email, $verification_code);

        return $this->login($request);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'username' => auth()->user()->name,
            'role' => auth()->user()->getRole(['user', 'admin'])->name
        ]);
    }

    /**
     * Verify the user account (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify()
    {
        $verified = false;
        $alreadyVerified = false;
        $code = request(['code']);

        $user = User::where(['verification_code' => $code])->first();

        if ($user) {
            if ($user->email_verified_at) {
                $alreadyVerified = true;
            } else {
                $user->email_verified_at = date("Y-m-d H:i:s");
                $user->save();

                $verified = true;
            }

        }

        return response()->json(['verified' => $verified, 'alreadyVerified' => $alreadyVerified]);
    }
}
