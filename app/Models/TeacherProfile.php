<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{
    protected $fillable = ['user_id', 'national_id', 'specialty', 'birthdate'];
    protected $casts = [
        'birthdate' => 'date',
    ];
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
