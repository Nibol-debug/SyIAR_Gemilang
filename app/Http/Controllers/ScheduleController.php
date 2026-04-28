<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\AcademicClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Menampilkan daftar semua jadwal.
     */
    public function index()
    {
        $schedules = Schedule::with(['academicClass', 'subject', 'instructor'])->latest()->get();
        return view('schedules.index', compact('schedules'));
    }

    /**
     * Menampilkan form tambah jadwal baru.
     */
    public function create()
    {
        $classes = AcademicClass::where('status', 'active')->get();
        $subjects = Subject::all();
        $instructors = User::where('role', 'instruktur')->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('schedules.create', compact('classes', 'subjects', 'instructors', 'days'));
    }

    /**
     * Menyimpan jadwal baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'academic_class_id' => 'required|exists:academic_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'instructor_id' => 'required|exists:users,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:100',
        ]);

        Schedule::create($request->only([
            'academic_class_id', 'subject_id', 'instructor_id', 'day', 'start_time', 'end_time', 'room'
        ]));

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit jadwal.
     */
    public function edit(Schedule $schedule)
    {
        $classes = AcademicClass::where('status', 'active')->get();
        $subjects = Subject::all();
        $instructors = User::where('role', 'instruktur')->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('schedules.edit', compact('schedule', 'classes', 'subjects', 'instructors', 'days'));
    }

    /**
     * Memperbarui data jadwal di database.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'academic_class_id' => 'required|exists:academic_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'instructor_id' => 'required|exists:users,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:100',
        ]);

        $schedule->update($request->only([
            'academic_class_id', 'subject_id', 'instructor_id', 'day', 'start_time', 'end_time', 'room'
        ]));

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diupdate!');
    }

    /**
     * Menghapus jadwal dari database.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}
