<?php

use App\Models\Base\KeyGen;
use App\Models\Base\Role;
use App\Models\Base\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * BUAT ROLE SUPER ADMIN
         */
        $create_user = User::create([
            'id' => KeyGen::randomKey(),
            'name' => 'Super Admin',
            'email' => 'superadmin@bpp.pekanbaru.go.id',
            'password' => password_hash('bpp1442', PASSWORD_BCRYPT)
        ]);

        /** @var User $user */
        $user = User::where('email', 'superadmin@bpp.pekanbaru.go.id')->first();

        /** @var Role $role */
        $role = Role::create(['name' => 'Super Admin', 'label' => []]);
        // atur permission yang akan diberikan
        $permissions = Permission::pluck('id', 'id')->all();
        // sinkronisasi role + permission
        $role->syncPermissions($permissions);
        // berikan akses ke user
        $user->assignRole([$role->id]);

// Role Pimpinan

        /** @var Role $role */
        $role = Role::create(['name' => 'Pimpinan', 'label' => [
            "01.01.",
            "02.01.",
            "03.01.",
            "04.01.",
            "05.01.",
            "06.02.",
            "07.01.",
            "08.01.",
            "09.01.",
            "10.01.",
            "11.01.",
            "12.01.",
            "13.01.",
            "14.01.",
            "15.01.",
            "16.01.",
            "17.01.",
            "18.01.",
            "19.01.",
            "20.01.",
            "21.01.",
            "22.01.",
            "23.01.",
            "24.01.",
            "25.01.",
            "26.01.",
            "27.01.",
            "28.01.",
            "29.01.",
            "30.01.",
            "31.01.",
            "32.01.",
            "33.01.",
            "34.01.",
            "35.01.",
            "36.01.",
            "38.01.",
            "39.01.",
            "40.01.",
            "42.01.",
            "43.01.",
            "44.01.",
            "45.01.",
            "46.01.",
            "47.01.",
            "48.01.",
            "49.01.",
            "50.01.",
            "51.01."
        ]]);
        // atur permission yang akan diberikan
        $permissions = Permission::whereIn('name', [
            "surat-masuk-list",
            "surat-keluar-list",
            "surat-keluar-edit",
            "template-surat-list",
            "agenda-list",
            "agenda-create",
            "agenda-edit",
            "agenda-delete",
            "home"
        ])->pluck('id', 'id')->all();
        // sinkronisasi role + permission
        $role->syncPermissions($permissions);

// Role Sekretaris

        /** @var Role $role */
        $role = Role::create(['name' => 'Sekretaris', 'label' => [
            "01.01.01.",
            "02.01.01.",
            "03.01.01.",
            "04.01.01.",
            "06.02.01.",
            "07.01.01.",
            "08.01.01.",
            "09.01.01.",
            "10.01.01.",
            "11.01.01.",
            "12.01.01.",
            "13.01.09.",
            "14.01.01.",
            "15.01.01.",
            "16.01.01.",
            "17.01.01.",
            "18.01.01.",
            "19.01.01.",
            "20.01.01.",
            "21.01.01.",
            "22.01.01.",
            "23.01.01.",
            "24.01.01.",
            "25.01.01.",
            "26.01.01.",
            "27.01.01.",
            "28.01.01.",
            "29.01.01.",
            "30.01.01.",
            "31.01.01.",
            "33.01.01.",
            "34.01.01.",
            "35.01.01.",
            "36.01.01.",
            "38.01.01.",
            "39.01.08.",
            "40.01.01.",
            "42.01.01.",
            "43.01.01.",
            "46.01.01.",
            "47.01.01.",
            "48.01.01.",
            "49.01.01.",
            "50.01.01.",
            "51.01.01."
        ]]);
        // atur permission yang akan diberikan
        $permissions = Permission::whereIn('name', [
            "surat-masuk-list",
            "surat-masuk-edit",
            "surat-keluar-list",
            "surat-keluar-create",
            "surat-keluar-edit",
            "template-surat-list",
            "agenda-list",
            "home"
        ])->pluck('id', 'id')->all();
        // sinkronisasi role + permission
        $role->syncPermissions($permissions);

// Role Kasubag

        /** @var Role $role */
        $role = Role::create(['name' => 'Kasubag', 'label' => [
            "01.01.01.01.",
            "02.01.01.01.",
            "03.01.01.01.",
            "04.01.01.01.",
            "05.01.01.02.",
            "06.02.01.01.",
            "07.01.01.01.",
            "08.01.01.01.",
            "09.01.01.01.",
            "10.01.01.01.",
            "11.01.01.01.",
            "12.01.01.01.",
            "13.01.09.01.",
            "14.01.01.01.",
            "15.01.01.01.",
            "16.01.01.01.",
            "17.01.01.01.",
            "18.01.01.01.",
            "19.01.01.01.",
            "20.01.01.06.",
            "21.01.01.01.",
            "22.01.01.01.",
            "23.01.01.01.",
            "24.01.01.01.",
            "25.01.01.01.",
            "26.01.01.01.",
            "27.01.01.04.",
            "28.01.01.02.",
            "29.01.01.01.",
            "30.01.01.01.",
            "31.01.01.01.",
            "32.01.01.01.",
            "33.01.01.01.",
            "34.01.01.01.",
            "35.01.01.01.",
            "36.01.01.01.",
            "38.01.01.01.",
            "39.01.08.01.",
            "40.01.01.01.",
            "42.01.01.01.",
            "43.01.01.01.",
            "44.01.03.",
            "45.01.01.",
            "46.01.01.01.",
            "47.01.01.01.",
            "48.01.01.01.",
            "49.01.01.01.",
            "50.01.01.01.",
            "51.01.01.01."
        ]]);
        // atur permission yang akan diberikan
        $permissions = Permission::whereIn('name', [
            "surat-masuk-list",
            "surat-masuk-list-opd",
            "surat-masuk-create",
            "surat-masuk-edit",
            "surat-keluar-list",
            "surat-keluar-create",
            "surat-keluar-edit",
            "template-surat-list",
            "arsip-surat-list",
            "arsip-surat-create",
            "arsip-surat-edit",
            "agenda-list",
            "agenda-create",
            "agenda-edit",
            "agenda-delete",
            "home"
        ])
            ->pluck('id', 'id')->all();
        // sinkronisasi role + permission
        $role->syncPermissions($permissions);

// Role Kabid

        /** @var Role $role */
        $role = Role::create(['name' => 'Kabid', 'label' => ["01.01.02.",
            "01.01.03.",
            "01.01.04.",
            "01.01.05.",
            "02.01.02.",
            "02.01.03.",
            "02.01.04.",
            "02.01.05.",
            "03.01.02.",
            "03.01.03.",
            "03.01.04.",
            "04.01.02.",
            "04.01.03.",
            "04.01.04.",
            "04.01.05.",
            "04.01.06.",
            "04.01.07.",
            "04.01.08.",
            "04.01.09.",
            "04.01.10.",
            "05.01.02.",
            "05.01.03.",
            "05.01.04.",
            "06.02.02.",
            "06.02.03.",
            "06.02.04.",
            "06.02.05.",
            "07.01.02.",
            "07.01.03.",
            "07.01.04.",
            "08.01.02.",
            "08.01.04.",
            "08.01.05.",
            "08.01.06.",
            "09.01.02.",
            "09.01.03.",
            "09.01.04.",
            "09.01.06.",
            "10.01.05.",
            "10.01.06.",
            "10.01.07.",
            "10.01.08.",
            "11.01.02.",
            "11.01.03.",
            "11.01.04.",
            "11.01.05.",
            "12.01.02.",
            "12.01.03.",
            "12.01.04.",
            "13.01.10.",
            "13.01.11.",
            "13.01.12.",
            "13.01.13.",
            "13.01.14.",
            "13.01.15.",
            "13.01.16.",
            "14.01.02.",
            "14.01.03.",
            "14.01.04.",
            "15.01.32.",
            "15.01.33.",
            "15.01.34.",
            "15.01.35.",
            "16.01.02.",
            "16.01.03.",
            "16.01.04.",
            "16.01.05.",
            "16.01.06.",
            "16.01.16.",
            "17.01.02.",
            "17.01.03.",
            "17.01.04.",
            "18.01.02.",
            "18.01.03.",
            "18.01.04.",
            "18.01.08.",
            "19.01.02",
            "19.01.03",
            "19.01.04",
            "19.01.05",
            "19.01.06",
            "19.01.07",
            "19.01.08",
            "20.01.03.",
            "20.01.04.",
            "20.01.05.",
            "20.01.06.",
            "21.01.02.",
            "21.01.03.",
            "21.01.04.",
            "22.01.02.",
            "22.01.03.",
            "22.01.04.",
            "22.01.05.",
            "25.01.02.",
            "25.01.03.",
            "25.01.04.",
            "25.01.10.",
            "24.01.02.",
            "24.01.03.",
            "24.01.04.",
            "25.01.02.",
            "25.01.03.",
            "26.01.02.",
            "26.01.03.",
            "26.01.04.",
            "26.01.15.",
            "27.01.06.",
            "27.01.07.",
            "27.01.08.",
            "28.01.02.",
            "28.01.03.",
            "28.01.04.",
            "29.01.02.",
            "29.01.03.",
            "29.01.04.",
            "30.01.02.",
            "30.01.03.",
            "30.01.04.",
            "30.01.05.",
            "31.01.02.",
            "31.01.03.",
            "31.01.04.",
            "31.01.05.",
            "31.01.06.",
            "32.01.02.",
            "32.01.03.",
            "32.01.04.",
            "32.01.05.",
            "32.01.10.",
            "33.01.02.",
            "33.01.03.",
            "33.01.04.",
            "33.01.05.",
            "33.01.06.",
            "34.01.12.",
            "34.01.13.",
            "34.01.14.",
            "34.01.15.",
            "34.01.24.",
            "35.01.02.",
            "35.01.03.",
            "35.01.04.",
            "35.01.05.",
            "36.01.02.",
            "36.01.03.",
            "36.01.04.",
            "36.01.05.",
            "36.01.06.",
            "38.01.02.",
            "38.01.03.",
            "38.01.04.",
            "38.01.05.",
            "38.01.10.",
            "39.01.09.",
            "39.01.10.",
            "39.01.11.",
            "39.01.12.",
            "39.01.21.",
            "40.01.02.",
            "40.01.03.",
            "40.01.04.",
            "40.01.05.",
            "40.01.15.",
            "42.01.02.",
            "42.01.03.",
            "42.01.04.",
            "42.01.05.",
            "42.01.06.",
            "43.01.02.",
            "43.01.03.",
            "43.01.04.",
            "43.01.05.",
            "44.01.01.",
            "44.01.02.",
            "45.01.02.",
            "45.01.03.",
            "45.01.04.",
            "46.01.02.",
            "46.01.03.",
            "46.01.04.",
            "46.01.05.",
            "46.01.06.",
            "47.01.02.",
            "47.01.03.",
            "47.01.04.",
            "47.01.05.",
            "47.01.06.",
            "48.01.02.",
            "48.01.03.",
            "48.01.04.",
            "48.01.05.",
            "48.01.06.",
            "49.01.02.",
            "49.01.03.",
            "49.01.04.",
            "49.01.05.",
            "49.01.06.",
            "50.01.02.",
            "50.01.03.",
            "50.01.04.",
            "50.01.05.",
            "50.01.06.",
            "51.01.02.",
            "51.01.03.",
            "51.01.04."]
        ]);
        // atur permission yang akan diberikan
        $permissions = Permission::whereIn('name', [
            "home",
            "agenda-list",
            "surat-keluar-list",
            "surat-keluar-edit",
            "surat-masuk-list",
            "surat-keluar-create",
            "surat-masuk-edit",
            "template-surat-list"
        ])->pluck('id', 'id')->all();
        // sinkronisasi role + permission
        $role->syncPermissions($permissions);

// Role STAFF

        /** @var Role $role */
        $role = Role::create(['name' => 'Staff', 'label' => []]);
        // atur permission yang akan diberikan
        $permissions = Permission::whereIn('name', [
            "home",
            "agenda-list",
            "surat-keluar-list",
            "surat-keluar-edit",
            "surat-masuk-list",
            "surat-keluar-create",
            "surat-masuk-edit",
            "template-surat-list"
        ])->pluck('id', 'id')->all();
        // sinkronisasi role + permission
        $role->syncPermissions($permissions);

    }
}
