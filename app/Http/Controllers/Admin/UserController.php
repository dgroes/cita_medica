<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    /* C32: Creación de nuevo Usuario */
    public function create()
    {
        //Recuperar roles para pasar a la View de Create.Users
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();

        /* C34: Guardar usuario en la BD */
        // Validación
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // 'password_confirmation' => 'required|string|min:8',
            'dni' => 'required|string|max:20|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role_name' => 'required|exists:roles,name',
        ]);

        $user = User::create($data);

        // $user->roles()->attach($data['role_id']);}

        // Asignar rol al usuario
        $user->assignRole($data['role_name']);

        // Mensaje de exito
        session()->flash('swal', [
            'title' => 'Usuario creado',
            'text' => 'El usuario: ' . $user->name . ' ha sido creado exitosamente.',
            'icon' => 'success',
            'showConfirmButton' => true,
        ]);
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
