<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['sender_id', 'consumer_id', 'info'];

    protected $table = 'messages';
    public function scopeFullTextSearch($query, string $searchTerm, array $columns = ['info'])
    {
        return $query->whereFullText($columns, $searchTerm);
    }
    public static function search(string $searchTerm, array $columns = ['info'])
    {
        return self::query()->fullTextSearch($searchTerm, $columns)->get();
    }
    public function sender()
    {
        return $this->hasOne(Profile::class, 'user_id', 'sender_id');
    }
    public function consumer()
    {
        return $this->hasOne(Profile::class, 'user_id', 'consumer_id');
    }
}