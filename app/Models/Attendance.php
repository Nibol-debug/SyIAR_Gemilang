<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['user_id', 'schedule_id', 'date', 'status', 'notes'];

    /**
     * Absensi milik satu user (peserta/instruktur).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Absensi milik satu jadwal.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
