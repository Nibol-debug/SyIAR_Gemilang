<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['branch_name', 'address'];

    /**
     * Cabang memiliki banyak user.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Cabang memiliki banyak kelas akademik.
     */
    public function academicClasses()
    {
        return $this->hasMany(AcademicClass::class);
    }
}
