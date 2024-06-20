<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Event extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
        'name' => 'array',
        'location' => 'array',
        'time' => 'array',
        'description' => 'array',
        'contactinfo' => 'array',
    ];

    /**
     * Get the responsible user for the event.
     */
    public function users() : \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class);
    }

    /**
     * Define loggable activities.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll();
    }

    /**
     * Get the signups for the event.
     */
    public function signups() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Signup::class);
    }

    /**
     * Get a translatable String for the event or fallback to de, fr and it in that order.
     */
    public function getTranslatable(string $key, string $locale):string
    {
        $translations = $this->$key;
        if (isset($translations[$locale])) {
            return $translations[$locale];
        }
        if (isset($translations['de'])) {
            return $translations['de'];
        }
        if (isset($translations['fr'])) {
            return $translations['fr'];
        }
        if (isset($translations['it'])) {
            return $translations['it'];
        }
        return "";
    }

}
