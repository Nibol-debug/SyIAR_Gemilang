<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    /**
     * Menampilkan daftar semua program / jurusan.
     */
    public function index()
    {
        $programs = Program::withCount(['subjects', 'academicClasses'])->latest()->get();
        return view('programs.index', compact('programs'));
    }

    /**
     * Menampilkan form tambah program baru.
     */
    public function create()
    {
        return view('programs.create');
    }

    /**
     * Menyimpan program baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'program_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Program::create([
            'program_name' => $request->program_name,
            'slug' => Str::slug($request->program_name),
            'description' => $request->description,
        ]);

        return redirect()->route('programs.index')->with('success', 'Program berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail program.
     */
    public function show(Program $program)
    {
        $program->load(['subjects', 'academicClasses.branch']);
        return view('programs.show', compact('program'));
    }

    /**
     * Menampilkan form edit program.
     */
    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    /**
     * Memperbarui data program di database.
     */
    public function update(Request $request, Program $program)
    {
        $request->validate([
            'program_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $program->update([
            'program_name' => $request->program_name,
            'slug' => Str::slug($request->program_name),
            'description' => $request->description,
        ]);

        return redirect()->route('programs.index')->with('success', 'Program berhasil diupdate!');
    }

    /**
     * Menghapus program dari database.
     */
    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('programs.index')->with('success', 'Program berhasil dihapus!');
    }
}
