<?php

namespace App\Http\Controllers\ModuleController;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class Module extends Controller
{
    public function index()
    {
        $modules = DB::table('modules')->get();
        return view('module_management.index', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_modules' => 'required|string|max:50',
            'judul_modules' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:300',
            'login' => 'required|boolean'
        ]);

        DB::table('modules')->insert([
            'nama_modules' => $request->nama_modules,
            'judul_modules' => $request->judul_modules,
            'deskripsi' => $request->deskripsi,
            'login' => $request->login
        ]);

        return redirect()->route('master-module')->with('success', 'Module berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $module = DB::table('modules')->where('id_modules', $id)->first();

        if (!$module) {
            return response()->json(['message' => 'Module tidak ditemukan.'], 404);
        }

        return response()->json($module);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_modules' => 'required|string|max:50',
            'judul_modules' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:300',
            'login' => 'required|boolean'
        ]);

        DB::table('modules')->where('id_modules', $id)->update([
            'nama_modules' => $request->nama_modules,
            'judul_modules' => $request->judul_modules,
            'deskripsi' => $request->deskripsi,
            'login' => $request->login
        ]);

        return redirect()->route('master-module')->with('success', 'Module berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('modules')->where('id_modules', $id)->delete();

        return redirect()->route('master-module')->with('success', 'Module berhasil dihapus.');
    }
}
