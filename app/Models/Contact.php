<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Contact extends Model
{
    use HasFactory, SoftDeletes, HasFilamentComments, LogsActivity;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'activities' => 'array',
    ];

    /**
     * Get the responsible user for the contact.
     */
    public function user() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_responsible_id');
    }

    /**
     * Get the contact's signups
     */
    public function signups() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Signup::class);
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
     * Hook into the model boot process
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($contact) {
            $contact->signups()->delete();
            $contact->email = $contact->email . '-deleted-' . now();
            $contact->save();
        });
    }
}
