<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['title', 'description', 'subject_id', 'academic_class_id', 'uploaded_by', 'file_path', 'file_type'];

    /**
     * Materi milik satu mata pelajaran.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Materi milik satu kelas akademik (opsional).
     */
    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    /**
     * Materi di-upload oleh satu user (instruktur).
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
