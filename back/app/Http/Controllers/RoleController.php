<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Resources\Roles\RolesResource;

class RoleController extends Controller
{
    // Method to get all roles
    public function index()
    {
       if (auth()->user()->id == 1) return response()->json(['roles' => RolesResource::collection(Role::orderBy('created_at', 'desc')->get())]);
       else return response()->json(['error' => 'Unauthorized access'], 403);
    }

    // Method to get a specific role by ID
    public function show($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        return response()->json(['role' => $role]);
    }

    // Method to create a new role
    public function store(Request $request)
    {
        $role = Role::where('name', $request->name)->first();

        if($role) return response([
            'status' => 'error',
            'message' => 'Role already exists'
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return response([
            'status' => 'success',
            'message' => 'Role created successfully'
        ]);
    }

    // Method to update a role by ID
    public function update(Request $request)
    {
        $role = Role::find($request->role_id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->update([
            'name' => $request->name
        ]);

        return response([
            'status' => 'success',
            'message' => 'Role updated successfully'
        ]);
    }

    // Method to delete a role by ID
    public function destroy(Request $request)
    {
        $role = Role::find($request->role_id);
        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found'
           ], 404);
        }

        $role->delete();
        return response()->json([
           'status' => 'success',
           'message' => 'Role deleted'
       ]);
    }
}
