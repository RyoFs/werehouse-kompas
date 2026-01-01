<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ActivityLog;

class UserController extends Controller
{
    /**
     * Halaman manajemen user (admin)
     */
    public function index()
    {
        return view('user.index', [
            'users' => User::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
            ActivityLog::add(
                "Menambahkan user baru: {$request->name} ({$request->email})"
            );

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Update user (modal edit)
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|min:6',
            ],
            [
                // NAME
                'name.required' => 'Nama wajib diisi.',
                'name.string'   => 'Nama harus berupa teks.',
                'name.max'      => 'Nama maksimal 255 karakter.',

                // EMAIL
                'email.required' => 'Email wajib diisi.',
                'email.email'    => 'Format email tidak valid.',
                'email.unique'   => 'Email sudah digunakan oleh user lain.',

                // PASSWORD
                'password.min'   => 'Password minimal 6 karakter.',
            ]
        );

        $user = User::findOrFail($id);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        ActivityLog::add(
            "Memperbarui user: {$user->name} ({$user->email})"
        );

        return back()->with('success', 'User berhasil diperbarui');
    }


    /**
     * Hapus user
     */
    public function destroy($id)
    {
        // ❌ cegah hapus diri sendiri
        if (Auth::id() == $id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        User::findOrFail($id)->delete();

        ActivityLog::add(
            "Menghapus user dengan ID: {$id}"
        );

        return back()->with('success', 'User berhasil dihapus');
    }
}
