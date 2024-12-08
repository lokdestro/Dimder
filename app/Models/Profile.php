<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'photo', 'bio', 'country', 
    'city', 'birthday', 'sex', 'interests', 'name', 'surname'];

    protected $table = 'profiles';
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id')->select("users.id", "users.name", "users.email");
    }
    public function scopeFullTextSearch($query, string $searchTerm, array $columns = ['name', 'surname'])
    {
        return $query->whereFullText($columns, $searchTerm);
    }
    public static function search(string $searchTerm, array $columns = ['name', 'surname'])
    {
        return self::query()->fullTextSearch($searchTerm, $columns)->get();
    }
}