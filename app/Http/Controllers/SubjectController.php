<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Program;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Menampilkan daftar semua mata pelajaran.
     */
    public function index()
    {
        $subjects = Subject::with('program')->latest()->get();
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Menampilkan form tambah mata pelajaran baru.
     */
    public function create()
    {
        $programs = Program::all();
        return view('subjects.create', compact('programs'));
    }

    /**
     * Menyimpan mata pelajaran baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'description' => 'nullable|string',
        ]);

        Subject::create($request->only(['subject_name', 'program_id', 'description']));

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit mata pelajaran.
     */
    public function edit(Subject $subject)
    {
        $programs = Program::all();
        return view('subjects.edit', compact('subject', 'programs'));
    }

    /**
     * Memperbarui data mata pelajaran di database.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'description' => 'nullable|string',
        ]);

        $subject->update($request->only(['subject_name', 'program_id', 'description']));

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil diupdate!');
    }

    /**
     * Menghapus mata pelajaran dari database.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}
