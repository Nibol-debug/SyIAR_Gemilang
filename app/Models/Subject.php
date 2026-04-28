<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['subject_name', 'program_id', 'description'];

    /**
     * Subject milik satu program.
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
