<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('admin.users', [
            'users'=> $users
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
            'name'=> ['required','alpha', 'min:3'],
            'email'=> ['required','email','unique:users'],
            'password'=> ['required','confirmed','min:8', 'string'],
            'role_id' => ['required', 'integer'],
            'phone' => ['required', 'regex:/^\+263(77|78|71|73|74)\d{7}$/']
        ]);

        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            $user->addRole($request->role_id);

            event(new Registered($user));

            return redirect()->back()->with('success','User created successfully');
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
            'name'=> ['required','alpha', 'min:3'],
            'email'=> ['required','email'],
            //'role_id' => ['required', 'integer'],
            'phone' => ['required', 'regex:/^\+263(77|78|71|73|74)\d{7}$/']
        ]);

        try{
            $user = User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return redirect()->back()->with('success','User updated successfully');
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
            User::find($id)->delete();


            return redirect()->back()->with('success','User deleted successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
