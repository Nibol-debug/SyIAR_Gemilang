<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\AcademicClass;
use App\Models\User;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Menampilkan daftar nilai (filterable).
     */
    public function index(Request $request)
    {
        $query = Grade::with(['user', 'subject', 'academicClass']);

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('academic_class_id')) {
            $query->where('academic_class_id', $request->academic_class_id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $grades = $query->latest()->paginate(25);
        $subjects = Subject::all();
        $classes = AcademicClass::where('status', 'active')->get();

        return view('grades.index', compact('grades', 'subjects', 'classes'));
    }

    /**
     * Menampilkan form input nilai.
     */
    public function create()
    {
        $subjects = Subject::all();
        $classes = AcademicClass::where('status', 'active')->with('branch')->get();
        $students = User::where('role', 'peserta')->get();
        $types = ['tugas', 'ujian', 'praktik', 'uts', 'uas'];

        return view('grades.create', compact('subjects', 'classes', 'students', 'types'));
    }

    /**
     * Menyimpan nilai baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_class_id' => 'required|exists:academic_classes,id',
            'type' => 'required|in:tugas,ujian,praktik,uts,uas',
            'title' => 'required|string|max:255',
            'score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        Grade::create($request->only([
            'user_id', 'subject_id', 'academic_class_id', 'type', 'title', 'score', 'notes'
        ]));

        return redirect()->route('grades.index')->with('success', 'Nilai berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit nilai.
     */
    public function edit(Grade $grade)
    {
        $subjects = Subject::all();
        $classes = AcademicClass::where('status', 'active')->with('branch')->get();
        $students = User::where('role', 'peserta')->get();
        $types = ['tugas', 'ujian', 'praktik', 'uts', 'uas'];

        return view('grades.edit', compact('grade', 'subjects', 'classes', 'students', 'types'));
    }

    /**
     * Memperbarui data nilai di database.
     */
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_class_id' => 'required|exists:academic_classes,id',
            'type' => 'required|in:tugas,ujian,praktik,uts,uas',
            'title' => 'required|string|max:255',
            'score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $grade->update($request->only([
            'user_id', 'subject_id', 'academic_class_id', 'type', 'title', 'score', 'notes'
        ]));

        return redirect()->route('grades.index')->with('success', 'Nilai berhasil diupdate!');
    }

    /**
     * Menghapus nilai dari database.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Nilai berhasil dihapus!');
    }
}
