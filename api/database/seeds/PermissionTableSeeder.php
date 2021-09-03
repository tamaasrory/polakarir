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
            'pola-karir',
            'surat-keluar',
            'template-surat',
            'arsip-surat',
            'jenis-surat',
            'agenda',
            'user',
            'role',
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
        // permission untuk munculkan seluruh surat keluar seluruh opd
        $permissions[] = 'surat-keluar-list-all';
        // permission untuk munculkan hanya surat keluar yang sesuai dengan "id_opd" user yang mengakses
        $permissions[] = 'surat-keluar-list-opd';

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


    }
}
