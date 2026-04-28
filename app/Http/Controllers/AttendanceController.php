<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Menampilkan daftar absensi (filterable).
     */
    public function index(Request $request)
    {
        $query = Attendance::with(['user', 'schedule.subject', 'schedule.academicClass']);

        if ($request->filled('schedule_id')) {
            $query->where('schedule_id', $request->schedule_id);
        }
        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        $attendances = $query->latest()->paginate(25);
        $schedules = Schedule::with(['subject', 'academicClass'])->get();

        return view('attendances.index', compact('attendances', 'schedules'));
    }

    /**
     * Menampilkan form input absensi (per jadwal, per tanggal).
     */
    public function create(Request $request)
    {
        $schedules = Schedule::with(['academicClass', 'subject'])->get();
        $students = collect();
        $selectedSchedule = null;

        if ($request->filled('schedule_id')) {
            $selectedSchedule = Schedule::with('academicClass')->find($request->schedule_id);
            if ($selectedSchedule) {
                // Ambil peserta yang ada di cabang yang sama dengan kelas
                $students = User::where('role', 'peserta')
                    ->where('branch_id', $selectedSchedule->academicClass->branch_id)
                    ->get();
            }
        }

        return view('attendances.create', compact('schedules', 'students', 'selectedSchedule'));
    }

    /**
     * Menyimpan data absensi (bulk insert).
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.user_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        foreach ($request->attendances as $data) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $data['user_id'],
                    'schedule_id' => $request->schedule_id,
                    'date' => $request->date,
                ],
                [
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                ]
            );
        }

        return redirect()->route('attendances.index')->with('success', 'Absensi berhasil disimpan!');
    }

    /**
     * Menghapus data absensi.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil dihapus!');
    }
}
