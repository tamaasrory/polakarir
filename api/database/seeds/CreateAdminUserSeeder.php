<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $create_user = User::create([
            'name' => 'Tama Asrory',
            'email' => 'admin@tajriy.com',
            'password' => password_hash('123456', PASSWORD_BCRYPT)
        ]);

        /** @var User $user */
        $user = User::where('email','admin@tajriy.com')->first();

        /** @var Role $role */
        $role = Role::create(['name' => 'admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
