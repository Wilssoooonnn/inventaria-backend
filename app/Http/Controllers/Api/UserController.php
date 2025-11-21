<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Konstruktor: Melindungi seluruh Controller dengan otorisasi Admin.
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /**
     * GET /api/users
     * Menampilkan daftar semua user (Admin dan Staff) dengan pagination.
     */
    public function index()
    {
        $users = User::with('location:id,name')->latest()->paginate(15);

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar user berhasil diambil.',
            'data' => $users
        ], 200);
    }

    /**
     * POST /api/users - Membuat User baru (Admin/Staff).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => ['required', Rule::in(['admin', 'staff'])],
            'location_id' => 'required|exists:locations,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'location_id' => $validated['location_id'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil dibuat.',
            'data' => $user
        ], 201);
    }

    /**
     * GET /api/users/{id}
     * Menampilkan detail satu user.
     */
    public function show(int $id)
    {
        $user = User::with('location')->find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $user], 200);
    }

    /**
     * PUT/PATCH /api/users/{id}
     * Memperbarui data user.
     */
    public function update(Request $request, int $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan.'], 404);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|min:8',
            'role' => ['required', Rule::in(['admin', 'staff'])],
            'location_id' => 'required|exists:locations,id',
        ];

        $validated = $request->validate($rules);
        $updateData = $validated;

        if (isset($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        } else {
            unset($updateData['password']);
        }

        $user->update($updateData);

        return response()->json([
            'status' => 'success',
            'message' => 'Data user berhasil diperbarui.',
            'data' => $user
        ], 200);
    }

    /**
     * DELETE /api/users/{id}
     * Menghapus user.
     */
    public function destroy(int $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan.'], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil dihapus.'
        ], 200);
    }
}