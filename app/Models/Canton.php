<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canton extends Model
{
    use HasFactory;

    protected $casts = [
        'name' => 'array',
    ];

    /**
     * Get the user for this canton
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Get the name of the canton in a specific language
     *
     * @param string $language
     * @return string
     */
    public function getName(string $language = 'de') : string
    {
        return $this->name[$language] ?? '';
    }
}
