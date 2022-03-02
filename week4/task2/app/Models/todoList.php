<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todoList extends Model
{
    use HasFactory;

    protected $table = "todolist";

    protected $fillable = ["title","content","stdate","enddate","image","user_id"];

     public $timestamps = false;
}
