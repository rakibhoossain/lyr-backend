<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use  App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }


    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    //Verify email
    public function verify(Request $request)
    {
        try {
            if ($request->user()->hasVerifiedEmail()) {
                return response()->json(['success' => true, 'message' => 'You have already verified email.'], 200);
            }

            $params = $request->only(['verify_user', 'expired', 'hash']);
            $fill = array_filter($params);
            if($fill < 3) throw new \Exception('Invalid verification url');

            $id = $fill['verify_user'];
            $expired = (integer)$fill['expired'];
            $hash = $fill['hash'];

            $now = \Carbon\Carbon::now()->getTimestamp();
            $expired = \Carbon\Carbon::parse($expired)->getTimestamp();
            if($now > $expired) throw new \Exception('Your email verification link is expired');

            if (! hash_equals((string) $id, (string) $request->user()->getKey())) throw new \Exception('Invalid email verification URL.');

            if(! hash_equals((string) $hash, sha1($request->user()->getEmailForVerification()))) throw new \Exception('Invalid email verification URL.');

            if ($request->user()->markEmailAsVerified()) {
                return response()->json(['success' => true, 'message' => 'Email verified successfully!.'], 200);
            }

            throw new \Exception('Email verification failed!');

        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['success' => true, 'message' => 'You have already verified email.'], 200);
        }

        $request->user()->sendEmailVerificationNotification();
        return response()->json(['success' => true, 'message' => 'Verification Email sent successfully!.'], 200);
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
        return $this->respondWithToken(auth()->refresh());
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
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 200);
    }

}
