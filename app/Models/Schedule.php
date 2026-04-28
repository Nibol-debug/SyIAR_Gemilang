<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['academic_class_id', 'subject_id', 'instructor_id', 'day', 'start_time', 'end_time', 'room'];

    /**
     * Jadwal milik satu kelas akademik.
     */
    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    /**
     * Jadwal milik satu mata pelajaran.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Jadwal milik satu instruktur.
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Jadwal memiliki banyak absensi.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
