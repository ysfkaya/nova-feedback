<?php

namespace Ysfkaya\NovaFeedback\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Ysfkaya\NovaFeedback\Interfaces\Status;

/**
 * Class Development
 * @package Ysfkaya\NovaFeedback\Models
 */
class Development extends Model implements Status
{

    /**
     * @var array
     */
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $value
     * @return string
     */
    public static function displayStatusByValue($value)
    {
        switch ($value) {
            case self::WAITING_APPROVAL:
                return self::htmlElement('warning', trans('nova-feedback::situations.waiting_approval'));
            case self::APPROVED:
                return self::htmlElement('primary', trans('nova-feedback::situations.approved'));
            case self::UNAPPROVED:
                return self::htmlElement('danger', trans('nova-feedback::situations.unapproved'));
            case self::IN_PROGRESS:
                return self::htmlElement('dark', trans('nova-feedback::situations.in_progress'));
            case self::SOLVED:
                return self::htmlElement('success', trans('nova-feedback::situations.solved'));
            case self::WAITING_PRICING:
                return self::htmlElement('white', trans('nova-feedback::situations.waiting_pricing'));
            case self::PRICED:
                return self::htmlElement('accent', trans('nova-feedback::situations.priced'));
            default:
                return '-';
        }
    }

    /**
     * @param $type
     * @param $text
     * @return string
     */
    public static function htmlElement($type, $text): string
    {
        return sprintf('<button type="button" class="btn btn-default cursor-default pointer-events-none btn-sm btn-%2$s">%1$s</button>', $text, $type);
    }


    /**
     * @return bool
     */
    public function markAsApproved()
    {
        return $this->update([
            'status' => self::APPROVED
        ]);
    }

    /**
     * @return bool
     */
    public function markAsUnApproved()
    {
        return $this->update([
            'status' => self::UNAPPROVED
        ]);
    }

    /**
     * @return bool
     */
    public function markAsInProgress()
    {
        return $this->update([
            'status' => self::IN_PROGRESS
        ]);
    }

    /**
     * @return bool
     */
    public function markAsSolved()
    {
        return $this->update([
            'status' => self::SOLVED
        ]);
    }


}
