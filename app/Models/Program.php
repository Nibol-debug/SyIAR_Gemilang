<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['program_name','slug', 'description'];

    /**
     * Program memiliki banyak mata pelajaran (subjects).
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    /**
     * Program memiliki banyak kelas akademik (academic classes).
     */
    public function academicClasses()
    {
        return $this->hasMany(AcademicClass::class);
    }
}
