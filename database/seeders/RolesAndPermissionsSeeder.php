<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    private $admin, $agency, $sale_head, $sale_manager, $csr, $customer;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create_roles();
        $this->create_permissions();
        $this->assign_permissions();
    }

    public function create_roles()
    {
        $this->admin = Role::firstOrCreate(['name' => 'admin']);
        $this->agency = Role::firstOrCreate(['name' => 'agency']);
        $this->sale_head = Role::firstOrCreate(['name' => 'sale-head']);
        $this->sale_manager = Role::firstOrCreate(['name' => 'sale-manager']);
        $this->csr = Role::firstOrCreate(['name' => 'csr']);
        $this->customer = Role::firstOrCreate(['name' => 'customer']);
    }

    public function create_permissions()
    {
        // Project
        Permission::firstOrCreate(['name' => 'view-all-projects']);
        Permission::firstOrCreate(['name' => 'view-project']);
        Permission::firstOrCreate(['name' => 'create-project']);
        Permission::firstOrCreate(['name' => 'update-project']);
        Permission::firstOrCreate(['name' => 'delete-project']);


        // Property 
        Permission::firstOrCreate(['name' => 'view-all-properties']);
        Permission::firstOrCreate(['name' => 'view-property']);
        Permission::firstOrCreate(['name' => 'create-property']);
        Permission::firstOrCreate(['name' => 'update-property']);
        Permission::firstOrCreate(['name' => 'delete-property']);

        //Uint
        Permission::firstOrCreate(['name' => 'view-all-uints']);
        Permission::firstOrCreate(['name' => 'view-unit']);
        Permission::firstOrCreate(['name'=> 'create-unit']);
        Permission::firstOrCreate(['name'=>'update-unit']);
        Permission::firstOrCreate(['name'=>'delete-unit']);


        // Floors 
        Permission::firstOrCreate(['name' => 'view-all-floors']);
        Permission::firstOrCreate(['name' => 'view-floor']);
        Permission::firstOrCreate(['name'=> 'create-floor']);
        Permission::firstOrCreate(['name'=>'update-floor']);
        Permission::firstOrCreate(['name'=>'delete-floor']);

        //User
        Permission::firstOrCreate(['name' => 'view-all-users']);
        Permission::firstOrCreate(['name' => 'view-user']);
        Permission::firstOrCreate(['name'=> 'create-user']);
        Permission::firstOrCreate(['name'=>'update-user']);
        Permission::firstOrCreate(['name'=>'delete-user']);

        //Comment
        Permission::firstOrCreate(['name' => 'view-all-comments']);
        Permission::firstOrCreate(['name' => 'view-comment']);
        Permission::firstOrCreate(['name'=> 'create-comment']);
        Permission::firstOrCreate(['name'=>'update-comment']);
        Permission::firstOrCreate(['name'=>'delete-comment']);
        
        //Blog
        Permission::firstOrCreate(['name' => 'view-all-blogs']);
        Permission::firstOrCreate(['name' => 'view-blog']);
        Permission::firstOrCreate(['name'=> 'create-blog']);
        Permission::firstOrCreate(['name'=>'update-blog']);
        Permission::firstOrCreate(['name'=>'delete-blog']);

        //Comment Image
        // Permission::firstOrCreate(['name' => 'view-all-images']);
        // Permission::firstOrCreate(['name' => 'view-image']);
        // Permission::firstOrCreate(['name'=> 'create-image']);
        // Permission::firstOrCreate(['name'=>'update-image']);
        // Permission::firstOrCreate(['name'=>'delete-image']);

        // employee 
        Permission::firstOrCreate(['name' => 'view-all-employees']);
        Permission::firstOrCreate(['name' => 'view-employee']);
        Permission::firstOrCreate(['name' => 'update-employee']);
        Permission::firstOrCreate(['name' => 'create-employee']);
        Permission::firstOrCreate(['name' => 'delete-employee']);








    }
    
    public function assign_permissions()
    {
        $this->admin->givePermissionTo(Permission::all());

        $this->agency->givePermissionTo([
            // permissions for projects 
            'view-all-projects',
            'view-project',
            'create-project',
            'update-project',
            'delete-project',

            // permissions for properties
            'view-all-properties',
            'view-property',

            //Permissions for Unit
             'view-all-uints',
            'view-unit',
            'create-unit',
            'update-unit',
            'delete-unit',

            //Permissions for Floor
             'view-all-floors',
            'view-floor',
            'create-floor',
            'update-floor',
            'delete-floor',

            // permissions for blogs 
            'view-all-blogs',
            'view-blog',

           //Permissions for employee
            'view-all-employees',
            'view-employee',
            'create-employee',
            'update-employee',
            'delete-employee',

            
            
        ]);

        $this->sale_manager->givePermissionTo([
            // permissions for projects 
            'view-all-projects',
            'view-project',
            'create-project',
            'update-project',
            'delete-project',

            // permissions for properties
            'view-all-properties',
            'view-property',
            'create-property',
            'update-property',
            'delete-property',


              //Permissions for Unit
             'view-all-uints',
            'view-unit',
            'create-unit',
            'update-unit',
            'delete-unit',

            //Permissions for Floor
             'view-all-floors',
            'view-floor',
            'create-floor',
            'update-floor',
            'delete-floor',

            // permissions for blogs 
            'view-all-blogs',
            'view-blog',
            // Permissions For Employees
            'view-all-employees',
            'view-employee',
            'create-employee',
            'update-employee',
            'delete-employee',
        ]);

        $this->sale_head->givePermissionTo([
             // permissions for projects 
            'view-all-projects',
            'view-project',
            'create-project',
            'update-project',
            'delete-project',

            // permissions for properties
            'view-all-properties',
            'view-property',
            'create-property',
            'update-property',
            'delete-property',


              //Permissions for Unit
             'view-all-uints',
            'view-unit',
            'create-unit',
            'update-unit',
            'delete-unit',

            //Permissions for Floor
             'view-all-floors',
            'view-floor',
            'create-floor',
            'update-floor',
            'delete-floor',

            // permissions for blogs 
            'view-all-blogs',
            'view-blog',
            
            // Permissions For Employees
            'view-all-employees',
            'view-employee',
            'create-employee',
            'update-employee',
            'delete-employee',
        ]);

        $this->csr->givePermissionTo([
            // permissions for projects 
            'view-all-projects',
            'view-project',
           

            // permissions for properties
            'view-all-properties',
            'view-property',


            //Permissions for Unit
            'view-all-uints',
            'view-unit',
           

            //Permissions for Floor
            'view-all-floors',
            'view-floor',
            'create-floor',
            'update-floor',
            'delete-floor',
            

            // permissions for blogs 
            'view-all-blogs',
            'view-blog',

            // Permissions For Employees
            'view-all-employees',
            'view-employee',
            'create-employee',
            'update-employee',
            'delete-employee',
        ]);


        $this->customer->givePermissionTo([
           // permissions for projects 
            'view-all-projects',
            'view-project',
           

            // permissions for properties
            'view-all-properties',
            'view-property',
            'create-property',
            'update-property',
            'delete-property',


              //Permissions for Unit
             'view-all-uints',
            'view-unit',
           

            //Permissions for Floor
             'view-all-floors',
            'view-floor',
            

            // permissions for blogs 
            'view-all-blogs',
            'view-blog',
        ]);
    }
}
