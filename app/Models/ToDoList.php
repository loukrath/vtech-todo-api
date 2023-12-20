<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ToDoList extends Model
{
    use HasFactory;

   /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
    
    protected $fillable = [
        'todo',
        'isCompleted'
    ];

    protected $appends = ['createdAt', 'updatedAt'];

    protected $hidden = ['created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4();
        });
    }

    
    public function getCreatedAtAttribute()
    {
        return $this->attributes['created_at'];
    }

   
    public function getUpdatedAtAttribute()
    {
        return $this->attributes['updated_at'];
    }
}
