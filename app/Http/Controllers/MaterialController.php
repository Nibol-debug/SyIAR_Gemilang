<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Subject;
use App\Models\AcademicClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::with(['subject', 'academicClass', 'uploader']);
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        $materials = $query->latest()->paginate(20);
        $subjects = Subject::all();
        return view('materials.index', compact('materials', 'subjects'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $classes = AcademicClass::where('status', 'active')->get();
        return view('materials.create', compact('subjects', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'academic_class_id' => 'nullable|exists:academic_classes,id',
            'file' => 'required|file|max:20480',
        ]);
        $file = $request->file('file');
        $path = $file->store('materials', 'public');
        Material::create([
            'title' => $request->title,
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'academic_class_id' => $request->academic_class_id,
            'uploaded_by' => auth()->id(),
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
        ]);
        return redirect()->route('materials.index')->with('success', 'Materi berhasil diupload!');
    }

    public function edit(Material $material)
    {
        $subjects = Subject::all();
        $classes = AcademicClass::where('status', 'active')->get();
        return view('materials.edit', compact('material', 'subjects', 'classes'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'academic_class_id' => 'nullable|exists:academic_classes,id',
            'file' => 'nullable|file|max:20480',
        ]);
        $data = $request->only(['title', 'description', 'subject_id', 'academic_class_id']);
        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $file = $request->file('file');
            $data['file_path'] = $file->store('materials', 'public');
            $data['file_type'] = $file->getClientOriginalExtension();
        }
        $material->update($data);
        return redirect()->route('materials.index')->with('success', 'Materi berhasil diupdate!');
    }

    public function destroy(Material $material)
    {
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Materi berhasil dihapus!');
    }

    public function download(Material $material)
    {
        if (!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
            return back()->with('error', 'File tidak ditemukan!');
        }
        return Storage::disk('public')->download($material->file_path, $material->title . '.' . $material->file_type);
    }
}
