<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */

namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    /**
     * The request instance.
     *
     * @var Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Create a new token.
     *
     * @param User $user
     * @return string
     */
    protected function jwt(User $user)
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
//            'exp' => time() + 60 * 60 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     *
     * @param User $user
     * @return mixed
     * @throws ValidationException
     */
    public function authenticate(User $user)
    {
        $this->validate($this->request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // Find the user by email
        /** @var User $user */
        $user = User::where('email', $this->request->input('email'))->first();
        if (!$user) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the
            // below respose for now.
            return response()->json([
                'msg' => 'Email Belum Terdaftar',
                'token' => null,
                'value' => null,
            ], 200);
        }
        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $user->password)) {

            $detail = $user->detail;
            $detail['lastAccess'] = date('Y-m-d H:i:s');

            /** @var User $data */
            $data = User::find($user->id);
            $data->detail = $detail;

            if ($data->save()) {
                return response()->json([
                    'token' => $this->jwt($data),
                    'value' => $data,
                ], 200);
            }

            return response()->json([
                'msg' => 'Email Belum Terdaftar',
                'token' => null,
                'value' => null,
            ], 200);
        }

        // Bad Request response
        return response()->json([
            'msg' => 'Email atau Password Salah',
            'token' => null,
            'value' => null,
        ], 200);
    }
}
