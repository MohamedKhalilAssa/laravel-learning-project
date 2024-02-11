<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;
    protected $fillable =['title','company','location','website','email','description','tags','image','user_id'];

    public function scopeFilter($query, array $filters){
        if($filters['tag'] ?? false){
            $query->where('tags','like','%'.$filters['tag'].'%');
        }
        if($filters['search'] ?? false){
            $query->where('tags','like','%'.$filters['search'].'%')
            ->orWhere('title','like','%'.$filters['search'].'%')
            ->orWhere('company','like','%'.$filters['search'].'%')
            ->orWhere('location','like','%'.$filters['search'].'%')
            ->orWhere('description','like','%'.$filters['search'].'%');
        }
    }
    // relationShip

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
