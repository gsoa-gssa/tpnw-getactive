<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parallax\FilamentComments\Models\FilamentComment;
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
            $comment = __("alerts.delete.deleted", ["model" => __("models.contacts.name"), "user" => auth()->user()->name, "date" => now()]);
            FilamentComment::create([
                'comment' => $comment,
                "subject_type" => "App\Models\Contact",
                "subject_id" => $contact->id,
                "user_id" => auth()->id(),
            ]);
            $contact->save();
        });

        static::restoring(function($contact) {
            $emailParts = explode("-deleted-", $contact->email);
            $email = $emailParts[0];
            $existing = Contact::where("email", $email)->count();
            if ($existing != 0) {
                Notification::make()
                    ->title(__("alerts.restore.emailinuse"))
                    ->danger()
                    ->send();
                return false;
            }
            $contact->email = $email;
            $contact->save();
            $comment = __("alerts.restore.restored", ["model" => __("models.contacts.name"), "user" => auth()->user()->name, "date" => now()]);
            FilamentComment::create([
                'comment' => $comment,
                "subject_type" => "App\Models\Contact",
                "subject_id" => $contact->id,
                "user_id" => auth()->id(),
            ]);
        });

        /** Before creating, check if the email exists for a deleted contact and restore it */
        static::creating(function($contact) {
            $existing = Contact::withTrashed()->where("email", "like", $contact->email . "-deleted-%")->first();
            if ($existing) {
                $existing->restore();
                $newFields = $contact->getAttributes();
                unset($newFields['id']);
                unset($newFields['created_at']);
                unset($newFields['updated_at']);
                unset($newFields['deleted_at']);
                $existing->update($newFields);
                $contact->id = $existing->id;
                return false;
            } else {
                return true;
            }
        });
    }

    /**
     * Get the tags for this contact.
     */
    public function tags() : \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Tag::class);
    }

    /**
     * Get the events this contact is responsible for.
     */
    public function events() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Event::class);
    }

    /**
     * Get the emails that were sent to this contact
     */
    public function emailNotifications() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\EmailNotification::class);
    }
}
