<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class State extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'code'
        ,   'alias'
        ,   'name'
        ,   'variant'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function form_contacts(): HasMany
    {
        return $this->hasMany(FormContact::class);
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
    public function get_states()
    {
        return self::orderBy('name', 'ASC')->get();
    }

    public static function get_states_alias()
    {
        $states = self::select('id', 'alias', 'name', 'variant')->orderBy('name', 'ASC')->get();
        $states->transform(function($state) {
            $state->code            = $state->alias;
            $state->name            = !is_null($state->variant) ? $state->variant : $state->name;
            unset($state->alias, $state->variant);
            return $state;
        });
        return $states;
    }
}
