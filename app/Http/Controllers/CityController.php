<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCityRequest;
use App\Models\City;
use App\Models\State;
use App\Tables\Cities;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Select;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\SpladeForm;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.cities.index', [
            'cities' => Cities::class
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $form = SpladeForm::make()
            ->action(route('admin.cities.store'))
            ->class('space-y-4 p-4 bg-white rounded')
            ->fields([
                Input::make('name')->label('Name'),
                Select::make('state_id')
                    ->label('Choose a state')
                    ->options(State::pluck('name', 'id')->toArray()),
                Submit::make()->label('Save')
            ]);

        return view('admin.cities.create', [
            'form' => $form
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCityRequest $request)
    {
        City::create($request->validated());

        Toast::title('Created!')
            ->message('New city created successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return to_route('admin.cities.index');
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
    public function edit(City $city)
    {
        $form = SpladeForm::make()
            ->action(route('admin.cities.update', $city))
            ->method('PUT')
            ->class('space-y-4 p-4 bg-white rounded')
            ->fill($city)
            ->fields([
                Input::make('name')->label('Name'),
                Select::make('state_id')
                    ->label('Choose a state')
                    ->options(State::pluck('name', 'id')->toArray()),
                Submit::make()->label('Save')
            ]);

        return view('admin.cities.edit', [
            'form' => $form
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateCityRequest $request, City $city)
    {
        $city->update($request->validated());

        Toast::title('Updated!')
            ->message('City updated successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return to_route('admin.cities.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();
        Toast::title('Deleted!')
            ->message('City deleted successfully')
            ->success()
            ->rightTop()
            ->backdrop()
            ->autoDismiss(1);
        return back();
    }
}
