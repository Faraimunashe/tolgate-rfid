<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TolfeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tolfees = Type::all();

        return view('admin.tolfees', [
            'tolfees'=> $tolfees
        ]);
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
            'class' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'amount' => ['required', 'numeric']
        ]);

        try{
            $type = new Type();
            $type->class = $request->class;
            $type->description = $request->description;
            $type->amount = $request->amount;
            $type->save();
            return redirect()->back()->with('success','Successfully added tolfee');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
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
        $request->validate([
            'class' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'amount' => ['required', 'numeric']
        ]);

        try{
            $type = Type::find($id);
            $type->class = $request->class;
            $type->description = $request->description;
            $type->amount = $request->amount;
            $type->save();
            return redirect()->back()->with('success','Successfully updated tolfee');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $type = Type::find($id);
            $type->delete();
            return redirect()->back()->with('success','Successfully deleted tolfee');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
