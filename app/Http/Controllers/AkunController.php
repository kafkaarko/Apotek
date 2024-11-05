<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akun = User::all();
        return view('acc.index', compact('akun'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('acc.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:akuns,email',
            'password' => 'required|min:1',
            'role' => 'required',
        ]);

        $proses = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        if ($proses) {
            return redirect()->route('acc.akun')->with('success', 'Berhasil mengubah data akun!');
        } else {
            return redirect()->back()->with('failed', 'Gagal mengubah data akun!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $akun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $akun, $id)
    {
        $akun = User::findOrFail($id);
        return view('acc.edit', compact("akun"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $akun, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'sometimes|required_if:old_email,'.$request->old_email.'|email|unique:users,email,'.$id.'|max:100',
            'password' => 'required|min:1',
            'role' => 'required|min:2|in:admin,user',
        ], [
            'name.required' => 'Nama harus diisi!',
            'email.required' => 'Email harus diisi!',
            'password.required' => 'Password harus diisi!',
            'name.max' => 'Nama maksimal 100 karakter!',
            'email.min' => 'Email minimal 3 karakter!',
        ]);
        
        $proses = User::where('id', $id)->update([
            'name' => $request->name,  // Perhatikan perbedaan 'name' di sini, bukan 'nama'
            'email' => $request->email,
            'password' => bcrypt($request->password),  // Enkripsi password sebelum disimpan
            'role' => $request->role,
        ]);
        
        if ($proses) {
            return redirect()->route('acc.akun')->with('success', 'Berhasil mengubah data akun!');
        } else {
            return redirect()->back()->with('failed', 'Gagal mengubah data akun!');
        }
        
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'berhasil menghapus Akun');
    }


    public function login()
    {
        return view('login');
    }
    public function loginAuth(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Ambil kredensial
    $user = $request->only(['email', 'password']);

    // Debugging untuk melihat kredensial
    // dd(Auth::attempt($user));

    if (Auth::attempt($user)) {
        // $request->session()->regenerate();
        return redirect()->route('home');
    } else {
        return redirect()->back()->with("failed", 'Gagal login, pastikan email dan password benar');
    }
}
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'anda telah logout');
    }
}
