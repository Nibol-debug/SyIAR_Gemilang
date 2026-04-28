<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicClass extends Model
{
    protected $fillable = ['class_name', 'program_id', 'branch_id', 'academic_year', 'status'];

    /**
     * Kelas akademik milik satu program.
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Kelas akademik milik satu cabang (branch).
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
