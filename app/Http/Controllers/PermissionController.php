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
        $form = SpladeForm::make()
            ->action(route('admin.permissions.store'))
            ->class('space-y-4 p-4 bg-white rounded')
            ->fields([
                Input::make('name')->label('Name'),

                Submit::make()->label('Save')
            ]);

        return view('admin.permissions.create', [
            'form' => $form
        ]);
    }

    public function store(CreatePermissionRequest $request)
    {
        Permission::create($request->validated());

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
        $form = SpladeForm::make()
            ->action(route('admin.permissions.update', $permission))
            ->method('PUT')
            ->class('space-y-4 p-4 bg-white rounded')
            ->fill($permission)
            ->fields([
                Input::make('name')->label('Name'),

                Submit::make()->label('Save')
            ]);

        return view('admin.permissions.edit', [
            'form' => $form
        ]);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());

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
