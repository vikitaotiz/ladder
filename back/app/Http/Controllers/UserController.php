<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Resources\Users\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index() {

        if (auth()->user()->id == 1) return response()->json(['users' => UserResource::collection(User::orderBy('created_at', 'desc')->get())]);
        else return response()->json(['error' => 'Unauthorized access'], 403);
    }

    public function store(Request $request) {

        try {
            /***********************************************************/
            DB::beginTransaction(); // Begining of a laravel transaction
            /***********************************************************/

            $userExist = User::where('name', $request->name)
                    ->where('email', $request->email)
                    ->first();

            if($userExist) return response([
                'status' => 'error',
                'message' => 'User already exists, try a different one.'
            ]);

            $roles = array();

            $fields = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string'
            ]);

            foreach($request->role_ids as $role_id){
                $roleId = Role::where('id', $role_id)->first()->id;
                array_push($roles, $roleId);
            };

            $user = User::create([
                'name' => $fields['name'],
                'active' => $request->active,
                'email' => $fields['email'],
                'password' => bcrypt($fields['password'])
            ]);

            if($user){
                $user->roles()->attach($roles);
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'User creation failed.'
                ]);
            };

            /******************************************/
            DB::commit(); // End of database transactions (Success)
            /******************************************/

            return response([
                'status' => 'success',
                'message' => 'User created successfully.'
            ]);


        } catch(\Exception $exp) {

            /*****************************************/
            DB::rollBack(); // Rollback
            /*****************************************/

            return response([
                'message' => $exp->getMessage(),
                'status' => 'error'
            ], 400);
        }
    }

    public function update(Request $request)
    {
        try {
            /***********************************************************/
            DB::beginTransaction(); // Begining of a laravel transaction
            /***********************************************************/

            $user = User::find($request->user_id);
            $roles = array();

            if($user){
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'active' => $request->active,
                ]);

                if($request->password) $user->update(['password' => bcrypt($request->password)]);

                foreach($request->role_ids as $role_id){
                    $role_id = Role::where('id', $role_id)->first()->id;
                    array_push($roles, $role_id);
                };

                $user->roles()->sync($roles);

                /******************************************/
                DB::commit(); // End of database transactions (Success)
                /******************************************/

                return response()->json([
                    "status" => "success",
                    "message" => "User updated successfully.",
                ]);

            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "User not found."
                ]);
            }

        } catch(\Exception $exp) {

            /*****************************************/
            DB::rollBack(); // Rollback
            /*****************************************/

            return response([
                'message' => $exp->getMessage(),
                'status' => 'error'
            ], 400);
        }
    }

    // Method to delete a role by ID
    public function destroy(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
           ], 404);
        }

        $user->delete();
        return response()->json([
           'status' => 'success',
           'message' => 'User deleted'
       ]);
    }
}
