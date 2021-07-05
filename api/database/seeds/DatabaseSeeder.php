<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // $this->call('UsersTableSeeder');
        $this->call('PermissionTableSeeder');
        $this->call('CreateAdminUserSeeder');
        $this->call(\Database\Seeders\JenisSuratTableSeeder::class);
        $this->call(\Database\Seeders\TemplateSuratTableSeeder::class);
        $this->call(\Database\Seeders\KlasifikasiSuratTebleSeeder::class);
        Model::reguard();
    }
}
