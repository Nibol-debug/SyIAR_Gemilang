<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        // Eager loading branch supaya tidak berat (N+1 Problem)
        $users = User::with('branch')->latest()->get();
        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah pengguna baru.
     */
    public function create()
    {
        $branches = Branch::all();
        $roles = ['admin', 'admin_cabang', 'instruktur', 'manajemen', 'peserta'];

        return view('users.create', compact('branches', 'roles'));
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,admin_cabang,instruktur,manajemen,peserta',
            'branch_id' => 'required|exists:branches,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'branch_id' => $request->branch_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit pengguna.
     */
    public function edit(User $user)
    {
        $branches = Branch::all();
        $roles = ['admin', 'admin_cabang', 'instruktur', 'manajemen', 'peserta'];

        return view('users.edit', compact('user', 'branches', 'roles'));
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,admin_cabang,instruktur,manajemen,peserta',
            'branch_id' => 'required|exists:branches,id',
        ]);

        // Ambil data selain password dulu
        $data = $request->only(['name', 'email', 'role', 'branch_id']);

        // Update password hanya jika diisi di form edit
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diupdate!');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        // Jangan biarkan admin menghapus dirinya sendiri (opsional tapi disarankan)
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Berhasil menghapus pengguna.');
    }
}