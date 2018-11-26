<?php

namespace Ysfkaya\NovaFeedback\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ErrorReportReply
 * @property ErrorReport errorReport
 * @package Ysfkaya\NovaFeedback\Models
 */
class ErrorReportReply extends Model
{
    use SoftDeletes;


    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $with = ['creator'];

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['errorReport'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|ErrorReport
     */
    public function errorReport()
    {
        return $this->belongsTo(ErrorReport::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(ErrorReportParticipant::class,'error_report_id','error_report_id');
    }


}
