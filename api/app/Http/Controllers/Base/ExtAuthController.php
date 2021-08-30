<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */

namespace App\Http\Controllers\Base;

use App\Models\Base\Role;
use App\Supports\ExtApi;
use App\Models\Base\User;
use App\Supports\Tools;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class ExtAuthController extends BaseController
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
    protected function jwt($param)
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $param, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            # 'exp' => time() + 60 * 60 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function refresh()
    {
        $auth = $this->request->auth;
        if ($auth) {
            return ['value' => $auth['perm']];
        }
        return ['value' => null];
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     *
     * @return mixed
     * @throws ValidationException
     */
    public function authenticate()
    {
        $this->validate($this->request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        // percobaan login ke sinergi
        $login = ExtApi::login($this->request);

        if ($login['result']) { // login sinergi berhasil dan user ditemukan

            $login['nama_pegawai'] = Tools::formatNameWithTitle($login['nama_pegawai']);

            // cek apakah user telah terdaftar di tabel user
            /** @var User $userData */
            $userData = User::find($login['nip']);

            $detail = [];

            if ($userData) { // sudah terdaftar dalam tabel user
                // rekam ip dan waktu akses
                $detail = $userData->detail;
            } else { // belum terdaftar dalam tabel user
                // tambahkan user ke tabel user
                $userData = new User();
                $userData->id = $login['nip'];
                $userData->name = $login['nama_pegawai'];
                $userData->esselon = $login['esselon'];
                $userData->fungsional = $login['fungsional'];
                $userData->kode_jabatan = $login['kode_jabatan'];
            }

            $detail['lastAccess'] = date('Y-m-d H:i:s');
            $detail['ip'] = $this->request->ip();
            $userData->detail = $detail;

            // set role yang sesuai dengan jabatan
            $userData->save();

            if (!isset($userData->id) && ($userData->id == null)) {
                /** @var User $userData */
                $userData = User::find($login['nip']);
            }

            // set role yang sesuai dengan jabatan
            $this->giveRole($userData, $login['kode_jabatan']);

            // paramater untuk pembuatan token jwt
            $param = [
                'id' => $login['nip'],
                'kdj' => $login['kode_jabatan']
            ];

            $userData->sinergi = $login;

            return response()->json([
                'token' => $this->jwt($param), // buat token untuk user ini
                'value' => $userData,
            ]);

        } else {  // login sinergi tidak berhasil atau user tidak ditemukan

            // cari user di tabel user langsung
            /** @var User $user */
            $user = User::where('email', $this->request->input('username'))
                ->first();

            if (!$user) { // bila user tidak juga ditemukan di tabel user
                return response()->json([
                    'msg' => 'Username atau Password Salah',
                    'token' => null,
                    'value' => null,
                ]);
            }

            // user ditemukan dan cek passwordnya
            if (Hash::check($this->request->input('password'), $user->password)) {
                // password sesuai
                // rekam ip dan waktu akses
                $detail = $user->detail;
                $detail['lastAccess'] = date('Y-m-d H:i:s');
                $detail['ip'] = $this->request->ip();
                $user->detail = $detail;

                // paramater untuk pembuatan token jwt
                $param = [
                    'id' => $user->id,
                    'kdj' => '-'
                ];

                if ($user->save()) {
                    return response()->json([
                        'token' => $this->jwt($param), // buat token untuk user ini
                        'value' => $user,
                    ]);
                }
            }
        }

        return response()->json([
            'msg' => 'Username atau Password Salah',
            'token' => null,
            'value' => null,
        ]);
    }

    /**
     * @param User $user
     * @param $kode_jabatan
     */
    public function giveRole($user, $kode_jabatan)
    {
        // cari role yang sesuai dengan kode jabatan
        $findRole = Role::whereRaw("label like '%\"{$kode_jabatan}\"%'")->first();
        if (!$findRole) {
            /*
             * bila kode jabatan tidak terdaftar di label tabel roles  maka akan
             * diberikan hak akses default yaitu "Staff"
             */
            $findRole = Role::findByName('Staff');
        }
        Log::info($user);
        Log::info($findRole);
        // beri hak akses ke user
        $user->assignRole([$findRole->id]);
        $user->save();
    }
}
