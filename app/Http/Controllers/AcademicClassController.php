<?php

namespace App\Http\Controllers;

use App\Models\AcademicClass;
use App\Models\Program;
use App\Models\Branch;
use Illuminate\Http\Request;

class AcademicClassController extends Controller
{
    /**
     * Menampilkan daftar semua kelas akademik.
     */
    public function index()
    {
        $classes = AcademicClass::with(['program', 'branch'])->latest()->get();
        return view('classes.index', compact('classes'));
    }

    /**
     * Menampilkan form tambah kelas baru.
     */
    public function create()
    {
        $programs = Program::all();
        $branches = Branch::all();
        return view('classes.create', compact('programs', 'branches'));
    }

    /**
     * Menyimpan kelas baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'branch_id' => 'required|exists:branches,id',
            'academic_year' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        AcademicClass::create($request->only(['class_name', 'program_id', 'branch_id', 'academic_year', 'status']));

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit kelas.
     */
    public function edit(AcademicClass $class)
    {
        $programs = Program::all();
        $branches = Branch::all();
        return view('classes.edit', compact('class', 'programs', 'branches'));
    }

    /**
     * Memperbarui data kelas di database.
     */
    public function update(Request $request, AcademicClass $class)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'branch_id' => 'required|exists:branches,id',
            'academic_year' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $class->update($request->only(['class_name', 'program_id', 'branch_id', 'academic_year', 'status']));

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil diupdate!');
    }

    /**
     * Menghapus kelas dari database.
     */
    public function destroy(AcademicClass $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dihapus!');
    }
}
