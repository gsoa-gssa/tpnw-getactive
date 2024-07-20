<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Signup extends Model
{
    use HasFactory, SoftDeletes, HasFilamentComments, LogsActivity;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'event_id' => 'integer',
        'contact_id' => 'integer',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
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
     * Get the email notification that belongs to this signup
     */
    public function emailNotifications(): HasMany
    {
        return $this->hasMany(EmailNotification::class);
    }

    /**
     * Hook into the model bootstrapping
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($signup) {
            if (!$signup->confirmation_email) {
                return;
            }
            $notification = new \App\Notifications\Signup\Confirmation($signup);
            $signup->contact->notify($notification);
            $data = $notification->toArray($signup->contact);
            $emailNotification = \App\Models\EmailNotification::create([
                'subject' => $data['subject'],
                'body' => $data['body'],
                'user_id' => $signup->contact->user->id,
                'contact_id' => $signup->contact->id,
                'signup_id' => $signup->id,
                'type' => $data['type'],
            ]);
        });
    }
}
