<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

/* C22: Ruta para los roles (Route::resource): */
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* C24: Creación de un nuevo registo */
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
        ]);

        Role::create(['name' => $request->name]);


        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol creado correctamente',
            'text' => 'El rol ha sido creado exitosamente.',
        ]);

        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //Impedir que se puedan editar los roles por defecto de las seeds (admin, doctor, paciente, recepcionista)
        if($role->name === 'Paciente' || $role->name === 'Doctor' || $role->name === 'Administrador' || $role->name === 'Recepcionista') {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error al editar el rol',
                'text' => 'No se puede editar el rol "' . $role->name . '".',
            ]);
            return redirect()->route('admin.roles.index');
        }

        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol actualizado correctamente',
            'text' => 'El rol ha sido actualizado exitosamente.',
        ]);

        return redirect()->route('admin.roles.edit', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //Impedir que se puedan editar los roles por defecto de las seeds (admin, doctor, paciente, recepcionista)
        if($role->name === 'Paciente' || $role->name === 'Doctor' || $role->name === 'Administrador' || $role->name === 'Recepcionista') {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error al eliminar el rol',
                'text' => 'No se puede eliminar el rol "' . $role->name . '".',
            ]);
            return redirect()->route('admin.roles.index');
        }

        $role->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol eliminado correctamente',
            'text' => 'El rol ha sido eliminado exitosamente.',
        ]);

        return redirect()->route('admin.roles.index');
    }
}
