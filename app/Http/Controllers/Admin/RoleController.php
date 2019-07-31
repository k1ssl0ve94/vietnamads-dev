<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            'roles' => Role::withCount('users')->get(),
            'permissions' => Permission::all(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:roles,name',
            'permissions' => 'array'
        ]);


        $role = Role::create(['name' => $request->name]);

        $permissions = $request->permissions;

        if (in_array('all', $permissions)) {
            $role->givePermissionTo(Permission::all());
        } else {
            $role->givePermissionTo($permissions);
        }

        return response()->json([
            'role' => $role,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $data = $role->toArray();
        $data['permissions'] = $role->permissions->pluck('name');
        return response()->json(['role' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|min:3|unique:roles,name,'.$role->id,
            'permissions' => 'array'
        ]);


        $permissions = $request->permissions;
        $role->name = $request->name;
        $role->save();

        if (in_array('all', $permissions)) {
            $role->syncPermissions(Permission::all());
        } else {
            $role->syncPermissions($permissions);
        }

        return response()->json([
            'role' => $role,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        // also delete all user belong to this role

        return response()->json(['success' => true]);
    }
}
