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

        /**
         * BUAT ROLE ADMINISTRATOR
         */
        $create_user = User::create([
            'id' => KeyGen::randomKey(),
            'name' => 'Administrator',
            'email' => 'administrator@bpp.pekanbaru.go.id',
            'password' => password_hash('bpp1442', PASSWORD_BCRYPT)
        ]);

        /** @var User $user */
        $user = User::where('email', 'administrator@bpp.pekanbaru.go.id')->first();

        /** @var Role $role */
        $role = Role::create(['name' => 'Administrator', 'label' => []]);
        // atur permission yang akan diberikan
        $permissions = Permission::whereIn('name', [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
        ])->pluck('id', 'id')->all();
        // sinkronisasi role + permission
        $role->syncPermissions($permissions);
        // berikan akses ke user
        $user->assignRole([$role->id]);

        /**
         * BUAT ROLE STAFF
         */
        $create_user = User::create([
            'id' => KeyGen::randomKey(),
            'name' => 'Staff',
            'email' => 'staff-only@bpp.pekanbaru.go.id',
            'password' => password_hash('bpp1442', PASSWORD_BCRYPT)
        ]);

        /** @var User $user */
        $user = User::where('email', 'staff-only@bpp.pekanbaru.go.id')->first();

        /** @var Role $role */
        $role = Role::create(['name' => 'Staff', 'label' => []]);

        // atur permission yang akan diberikan
        $permissions = Permission::whereIn('name', [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
        ])->pluck('id', 'id')->all();
        // sinkronisasi role + permission
        $role->syncPermissions($permissions);
        // berikan akses ke user
        $user->assignRole([$role->id]);
    }
}
