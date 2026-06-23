<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: view_users_list", [
            'correlationId' => $correlationId,
            'userId' => $userId
        ]);

        try {
            $users = User::orderBy('id', 'desc')->get();

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: view_users_list", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'count' => $users->count(),
                'duration' => $duration
            ]);

            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: view_users_list", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            abort(500, 'Gagal mengambil data pengguna.');
        }
    }

    public function updateRole(Request $request, $id)
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: update_user_role", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'target_user_id' => $id,
            'new_role' => $request->input('role')
        ]);

        try {
            $user = User::findOrFail($id);

            // Pengamanan: Mencegah admin mendemotasi dirinya sendiri
            if ($user->id === $userId) {
                $duration = round((microtime(true) - $startTime) * 1000, 2);
                Log::warn("Operation warning: update_user_role - Self-demotion prevention triggered", [
                    'correlationId' => $correlationId,
                    'userId' => $userId,
                    'duration' => $duration
                ]);
                return redirect()->back()->withErrors(['role' => 'Anda tidak diizinkan mengubah role Anda sendiri untuk mencegah kegagalan akses sistem.']);
            }

            $request->validate([
                'role' => 'required|in:admin,pelanggan',
            ]);

            $oldRole = $user->role;
            $user->update([
                'role' => $request->role
            ]);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: update_user_role", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'target_user_id' => $id,
                'old_role' => $oldRole,
                'new_role' => $request->role,
                'duration' => $duration
            ]);

            return redirect()->back()->with('success', "Role {$user->name} berhasil diubah menjadi {$request->role}.");
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: update_user_role", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'target_user_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui role pengguna: ' . $e->getMessage()]);
        }
    }
}
