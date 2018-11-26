<?php /** @noinspection PhpInconsistentReturnPointsInspection */


namespace Ysfkaya\NovaFeedback\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ErrorReport
 *
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property ErrorReportReply replies
 * @package App
 */
class ErrorReportParticipant extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['error_report_id', 'user_id', 'last_read'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_read'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function errorReport()
    {
        return $this->belongsTo(ErrorReport::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo+
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
