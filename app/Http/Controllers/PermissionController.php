<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Tables\Permissions;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\SpladeForm;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {

        return view('admin.permissions.index', [
            'permissions' => Permissions::class
        ]);
    }

    public function create()
    {
        return view('admin.permissions.create', [
            'roles' => Role::pluck('name', 'id')->toArray()
        ]);
    }

    public function store(CreatePermissionRequest $request)
    {
        $permission = Permission::create($request->validated());
        $permission->syncRoles($request->roles);

        Toast::title('Created!')
            ->message('New permission created successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return to_route('admin.permissions.index');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', [
            'permission' => $permission,
            'roles' => Role::pluck('name', 'id')->toArray()
        ]);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        $permission->syncRoles($request->roles);

        Toast::title('Updated!')
            ->message('Permission updated successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return to_route('admin.permissions.index');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        Toast::title('Deleted!')
            ->message('Permission deleted successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return back();
    }
}
