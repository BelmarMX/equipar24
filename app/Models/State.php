<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends  = [
            'human_created_at'
        ,   'created_dmy'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function form_contacts(): HasMany
    {
        return $this->hasMany(FormContact::class);
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * MUTATORS AND ACCESSORS
    ----------------------------------------------------------------------------------------------------------------- */
    protected function humanCreatedAt(): Attribute
    {
        $human = !empty($this->created_at) ? ucfirst($this->created_at->diffForHumans()) : NULL;
        return Attribute::make(
            get: fn() => $human
        );
    }
    protected function createdDmy(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->created_at)->format('d/m/Y H:i')
        );
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
