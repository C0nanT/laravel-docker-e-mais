<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        if(request()->has('search')) {
            return $this->search(request()->get('search'));
        }

        $users = User::all();
        return response()->json([
            'data' => $users
        ], 200);
    }

    public function show(User $user)
    {
        return response()->json([
            'user' => $user
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function update(Request $request, User $user)
    {
        if($request->method() === 'PATCH') {
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
                'password' => 'sometimes|required|min:6',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'required|min:6',
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        if (isset($validated['email']) && $validated['email'] !== $user->email) {
            $user->email_verified_at = null; 
            $user->remember_token = null;
        }

        $user->update($validated);
        $user->save();
        
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

    protected function search($query)
    {
        if (empty($query)) {
            return response()->json([
                'message' => 'Query parameter is required'
            ], 422);
        }

        $query = trim($query);

        $users = User::where('name', 'ILIKE', "%{$query}%")
            ->get();
    
        return response()->json([
            'users' => $users
        ], 200);
    }
}
