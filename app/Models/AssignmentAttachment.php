<?php

// app/Models/AssignmentAttachment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentAttachment extends Model
{
    protected $fillable = ['assignment_id','original_name','path','mime','size'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
