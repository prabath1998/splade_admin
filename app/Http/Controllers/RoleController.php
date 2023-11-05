<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Tables\Roles;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\SpladeForm;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Roles::class
        ]);
    }

    public function create()
    {
        // $form = SpladeForm::make()
        //     ->action(route('admin.roles.store'))
        //     ->class('space-y-4 p-4 bg-white rounded')
        //     ->fields([
        //         Input::make('name')->label('Name'),

        //         Submit::make()->label('Save')
        //     ]);

        return view('admin.roles.create', [
            'permissions' => Permission::pluck('name', 'id')->toArray()
        ]);
    }

    public function store(CreateRoleRequest $request)
    {
        $role = Role::create($request->validated());
        $role->syncPermissions($request->permissions);

        Toast::title('Created!')
            ->message('New role created successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return to_route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        // $form = SpladeForm::make()
        //     ->action(route('admin.roles.update', $role))
        //     ->method('PUT')
        //     ->class('space-y-4 p-4 bg-white rounded')
        //     ->fill($role)
        //     ->fields([
        //         Input::make('name')->label('Name'),

        //         Submit::make()->label('Save')
        //     ]);

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => Permission::pluck('name', 'id')->toArray()
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        $role->syncPermissions($request->permissions);

        Toast::title('Updated!')
            ->message('Role updated successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return to_route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        Toast::title('Deleted!')
            ->message('Role deleted successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return back();
    }
}
