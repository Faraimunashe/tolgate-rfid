<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'regnum' => ['required', 'string'],
            'make' => ['required', 'string'],
            'model' => ['required', 'string'],
            'type_id' => ['required', 'integer'],
            'code' => ['required', 'string']
        ]);

        try{
            $vehicle = new Vehicle();
            $vehicle->user_id = Auth::id();
            $vehicle->regnum = $request->regnum;
            $vehicle->model = $request->model;
            $vehicle->code = $request->code;
            $vehicle->make = $request->make;
            $vehicle->type_id = $request->type_id;
            $vehicle->balance = 0.0;
            $vehicle->save();

            return redirect()->back()->with('success','Vehicle registered successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
