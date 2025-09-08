<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('read_user');
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    /* C32: Creación de nuevo Usuario */
    public function create()
    {
        Gate::authorize('create_user');
        //Recuperar roles para pasar a la View de Create.Users
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create_user');
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

        // Si el usuario es de tipo Paciente, crear un registro de paciente asociado
        if ($user->hasRole('Paciente')) {
            $patient = $user->patient()->create([]); // Crear paciente asociado al usuario
            return redirect()->route('admin.patients.edit', $patient->id);
        }

        //Si el usuario es de tipo Doctor, redirigir a la vista de edición de Doctor
        if ($user->hasRole('Doctor')) {
            $doctor = $user->doctor()->create([]); // Crear doctor asociado al usuario
            return redirect()->route('admin.doctors.edit', $doctor);
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('read_user');
        // return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        Gate::authorize('update_user');
        //Recuperar roles para pasar a la View de Edit.Users
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */

    /* C35: Edición de usuario (syncRoles) */
    public function update(Request $request, User $user)
    {
        Gate::authorize('update_user');
        // return $request->all();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'dni' => 'required|string|max:20|unique:users,dni,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role_name' => 'required|exists:roles,name',
        ]);
        // dd($data);
        $user->update($data);

        // Si se proporciona una nueva contraseña, actualizarla
        if ($request->password) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        // Asignar rol al usuario
        $user->syncRoles([$request->role_name]);

        // Mensaje de exito
        session()->flash('swal', [
            'title' => 'Usuario actualizado',
            'text' => 'El usuario: ' . $user->name . ' ha sido actualizado exitosamente.',
            'icon' => 'success',
            'showConfirmButton' => true,
        ]);
        return redirect()->route('admin.users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete_user');
        $user->roles()->detach(); // Desasignar roles (elimina la relación de model_has_roles)
        $user->delete(); // Eliminar usuario

        session()->flash('swal', [
            'title' => 'Usuario eliminado',
            'text' => 'El usuario: ' . $user->name . ' ha sido eliminado exitosamente.',
            'icon' => 'success',
            'showConfirmButton' => true,
        ]);
        return redirect()->route('admin.users.index');
    }
}
