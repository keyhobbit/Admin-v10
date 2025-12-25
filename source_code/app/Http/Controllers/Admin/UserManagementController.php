<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Get all users with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $search = $request->input('search');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Get single user
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Create new user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|min:8',
        ]);

        $data = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Ban/unban user
     */
    public function toggleBan($id)
    {
        $user = User::findOrFail($id);
        
        // You can add a 'banned_at' column to users table later
        // For now, we'll just return a message
        
        return response()->json([
            'message' => 'User ban status updated (add banned_at column to implement)',
            'user' => $user,
        ]);
    }

    /**
     * Get user statistics
     */
    public function stats()
    {
        $totalUsers = User::count();
        $todayUsers = User::whereDate('created_at', today())->count();
        $weekUsers = User::where('created_at', '>=', now()->subDays(7))->count();
        $monthUsers = User::where('created_at', '>=', now()->subMonth())->count();

        return response()->json([
            'total_users' => $totalUsers,
            'today' => $todayUsers,
            'this_week' => $weekUsers,
            'this_month' => $monthUsers,
        ]);
    }
}
