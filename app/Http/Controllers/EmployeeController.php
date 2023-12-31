<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\State;
use App\Tables\Employees;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\FormBuilder\Date;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Select;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\SpladeForm;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.employees.index', [
            'employees' => Employees::class
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $form = SpladeForm::make()
            ->action(route('admin.employees.store'))
            ->class('space-y-4 p-4 bg-white rounded')
            ->fields([
                Input::make('first_name')->label('First Name'),
                Input::make('last_name')->label('Last Name'),
                Input::make('middle_name')->label('Middle Name'),
                Input::make('zip_code')->label('Zip Code'),

                Select::make('city_id')
                    ->label('Choose a city')
                    ->options(City::pluck('name', 'id')->toArray()),

                Select::make('department_id')
                    ->label('Choose a department')
                    ->options(Department::pluck('name', 'id')->toArray()),

                Date::make('birth_date')->label('Birth Date'),
                Date::make('date_hired')->label('Date Hired'),

                Submit::make()->label('Save')
            ]);

        return view('admin.employees.create', [
            'form' => $form
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmployeeRequest $request)
    {

        $city = City::findOrFail($request->city_id);
        // $city = City::findOrFail($request->city_id);
        Employee::create(array_merge($request->validated(), [
            'country_id' => $city->state->country_id,
            'state_id' => $city->state_id,
        ]));

        Toast::title('Created!')
            ->message('New employee saved successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return to_route('admin.employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $form = SpladeForm::make()
            ->action(route('admin.employees.update', $employee))
            ->method('PUT')
            ->class('space-y-4 p-4 bg-white rounded')
            ->fill($employee)
            ->fields([
                Input::make('first_name')->label('First Name'),
                Input::make('last_name')->label('Last Name'),
                Input::make('middle_name')->label('Middle Name'),
                Input::make('zip_code')->label('Zip Code'),

                Select::make('city_id')
                    ->label('Choose a city')
                    ->options(City::pluck('name', 'id')->toArray()),

                Select::make('department_id')
                    ->label('Choose a department')
                    ->options(Department::pluck('name', 'id')->toArray()),

                Date::make('birth_date')->label('Birth Date'),
                Date::make('date_hired')->label('Date Hired'),
                Submit::make()->label('Save')
            ]);

        return view('admin.employees.edit', [
            'form' => $form
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEmployeeRequest $request, Employee $employee)
    {
        $city = City::findOrFail($request->city_id);
        $employee->update(array_merge($request->validated(), [
            'country_id' => $city->state->country_id,
            'state_id' => $city->state_id,
        ]));

        Toast::title('Updated!')
            ->message('Employee updated successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return to_route('admin.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        Toast::title('Deleted!')
            ->message('Employee deleted successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return back();
    }
}
