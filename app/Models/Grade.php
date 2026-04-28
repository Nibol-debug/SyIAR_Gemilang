<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['user_id', 'subject_id', 'academic_class_id', 'type', 'title', 'score', 'notes'];

    /**
     * Nilai milik satu peserta.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Nilai milik satu mata pelajaran.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Nilai milik satu kelas akademik.
     */
    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }
}
