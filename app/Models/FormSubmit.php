<?php

namespace App\Models;

use App\Classes\Navigation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSubmit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'form_contact_id'
        ,   'type'
        ,   'comment'
        ,   'notes'
        ,   'status'
        ,   'approved_by_user_id'
        ,   'rejected_by_user_id'
        ,   'approved_at'
        ,   'rejected_at'
    ];

    protected $appends  = [
            'human_created_at'
        ,   'created_dmy'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function form_contact(): BelongsTo
    {
        return $this->belongsTo(FormContact::class);
    }

    public function form_quotation_details(): ?HasMany
    {
        if( $this->type=='quotation' )
        {
            return $this->hasMany(FormQuotationDetail::class);
        }
        return NULL;
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_user_id');
    }

    public function rejected_by()
    {
        return $this->belongsTo(User::class, 'rejected_by_user_id');
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
    public static function get_all_contacts()
    {
        return self::where('type', 'contact')->orderBy('created_at', 'DESC')->get();
    }

    public static function get_all_quotations()
    {
        return self::where('type', 'quotation')->orderBy('created_at', 'DESC')->get();
    }

    public static function get_monthly_contacts()
    {
        $carbon = new Carbon();
        return self::where('type', 'contact')
            ->whereBetween('created_at', [$carbon->parse(now())->startOfMonth(), $carbon->parse(now())->endOfMonth()])
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function get_monthly_quotations()
    {
        $carbon = new Carbon();
        return self::where('type', 'quotation')
            ->whereBetween('created_at', [$carbon->parse(now())->startOfMonth(), $carbon->parse(now())->endOfMonth()])
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function get_all_contacts_pending()
    {
        return self::where('type', 'contact')
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function get_all_quotations_pending()
    {
        return self::where('type', 'quotation')
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function get_monthly_contacts_pending()
    {
        $carbon = new Carbon();
        return self::where('type', 'contact')
            ->where('status', 'pending')
            ->whereBetween('created_at', [$carbon->parse(now())->startOfMonth(), $carbon->parse(now())->endOfMonth()])
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function get_monthly_quotations_pending()
    {
        $carbon = new Carbon();
        return self::where('type', 'quotation')
            ->where('status', 'pending')
            ->whereBetween('created_at', [$carbon->parse(now())->startOfMonth(), $carbon->parse(now())->endOfMonth()])
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function get_statistics()
    {
        $stats                              = new \stdClass();
        $stats->contacts_total              = self::get_all_contacts()->count();
        $stats->contacts_month              = self::get_monthly_contacts()->count();
        $stats->contacts_month_pending      = self::get_monthly_contacts_pending()->count();
        $stats->healt_contacts_month        = self::set_healt($stats->contacts_month_pending,$stats->contacts_month);
        $stats->quotations_total            = self::get_all_quotations()->count();
        $stats->quotations_month            = self::get_monthly_quotations()->count();
        $stats->quotations_month_pending    = self::get_monthly_quotations_pending()->count();
        $stats->healt_quotations_month      = self::set_healt($stats->quotations_month_pending, $stats->quotations_month);

        return $stats;
    }

    public static function set_healt($pending, $total)
    {
        $percent = Navigation::percent($total, $pending);
        if( $percent != 0 )
        { $percent = $percent * -1; }

        if( $pending > 0 && $percent < 35 )
        {
            return 'danger';
        }
        elseif( $pending > 0 && $percent < 70 )
        {
            return 'warning';
        }
        else
        {
            return 'success';
        }
    }

    public static function set_healt_message($healt)
    {
        if( $healt == 'success' )
        {
            return 'Continúa así';
        }
        elseif( $healt == 'warning' )
        {
            return 'Es necesario prestar atención';
        }
        else
        {
            return 'Es Urgente atender a los contactos';
        }
    }

    public function calculate_value_quotation($only_estimated = TRUE)
    {
        if( $this->type == 'contact' )
        {
            return NULL;
        }
        $details                = $this->form_quotation_details()->get();
        $calculated             = new \stdClass();
        $calculated->original   = 0;
        $calculated->discount   = 0;
        $calculated->unitary    = 0;
		$calculated->total      = 0;
        $estimated              = 0;
        foreach($details AS $detail)
        {
            $calculated->original   = $calculated->original + ($detail->quantity * $detail->original_price);
            $calculated->discount   = $calculated->discount + ($detail->quantity * $detail->discount);
            $calculated->unitary    = $calculated->unitary + $detail->total;
            $calculated->total      = $estimated = $estimated + ($detail->quantity * $detail->total);
        }
        $calculated->iva        = $calculated->total-($calculated->total / 1.16);

        if( $only_estimated )
        {
            return '$'.number_format($estimated);
        }
        return $calculated;
    }
}
