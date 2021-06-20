<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $models = [
            'surat-masuk',
            'surat-keluar',
            'user',
            'role',
            'jenis-surat'
        ];
        $actions = [
            'list',
            'create',
            'edit',
            'delete',
        ];

        $permissions = [];
        foreach ($models as $model) {
            foreach ($actions as $action) {
                $permissions[] = $model . '-' . $action;
            }
        }

        $permissions[] = 'home';

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
