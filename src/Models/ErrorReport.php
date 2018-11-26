<?php /** @noinspection PhpInconsistentReturnPointsInspection */


namespace Ysfkaya\NovaFeedback\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ysfkaya\NovaFeedback\Interfaces\Priority;
use Ysfkaya\NovaFeedback\Interfaces\Status;

/**
 * Class ErrorReport
 *
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property ErrorReportReply replies
 * @method Builder forUser($userId)
 * @method Builder forCurrentUser()
 * @package App
 */
class ErrorReport extends Model implements Status, Priority
{
    use SoftDeletes;


    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $appends = [
        'updated_ago',
        'created_at_localized',
        'status_html',
        'priority_html',
        'is_solved',
        'last_reply_user'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function replies()
    {
        return $this->hasMany(ErrorReportReply::class, 'error_report_id')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(ErrorReportParticipant::class);
    }

    public function getLastReplyUserAttribute()
    {
        return optional($this->replies()->first())->creator;
    }

    /**
     * Returns threads that the user is associated with.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser(Builder $query, $userId)
    {
        $participantsTable = 'error_report_participants';
        $errorReportTable = 'error_reports';

        return $query->join($participantsTable, $this->getQualifiedKeyName(), '=', $participantsTable . '.error_report_id')
            ->where($participantsTable . '.user_id', $userId)
            ->where($participantsTable . '.deleted_at', null)
            ->select($errorReportTable . '.*');
    }

    /**
     * Returns threads that the user is associated with.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCurrentUser(Builder $query)
    {
        return $query->forUser(auth()->id());
    }


    /**
     * Mark a thread as read for a user.
     *
     * @param int $userId
     *
     * @return void
     */
    public function markAsRead($userId)
    {
        try {
            $participant = $this->getParticipantFromUser($userId);
            $participant->last_read = new Carbon();
            $participant->save();
        } catch (ModelNotFoundException $e) { // @codeCoverageIgnore
            // do nothing
        }
    }

    /**
     * Mark a thread as read for a current user.
     *
     * @return void
     */
    public function markAsReadByCurrentUser()
    {
        $this->markAsRead(auth()->id());
    }

    /**
     * Restores all participants within a thread that has a new message.
     *
     * @return void
     */
    public function activateAllParticipants()
    {
        $participants = $this->participants()->withTrashed()->get();

        foreach ($participants as $participant) {
            $participant->restore();
        }
    }

    /**
     * Finds the participant record from a user id.
     *
     * @param $userId
     *
     * @return mixed
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getParticipantFromUser($userId)
    {
        return $this->participants()->where('user_id', $userId)->firstOrFail();
    }


    /**
     * Add users to thread as participants.
     *
     * @param array|mixed $userId
     *
     * @return void
     */
    public function addParticipant($userId)
    {
        $userIds = is_array($userId) ? $userId : (array)func_get_args();

        collect($userIds)->each(function ($userId) {
            ErrorReportParticipant::firstOrCreate([
                'user_id' => $userId,
                'error_report_id' => $this->id,
            ]);
        });
    }

    /**
     * Remove participants from error report.
     *
     * @param array|mixed $userId
     *
     * @return void
     */
    public function removeParticipant($userId)
    {
        $userIds = is_array($userId) ? $userId : (array)func_get_args();

        ErrorReportParticipant::where('error_report_id', $this->id)->whereIn('user_id', $userIds)->delete();
    }

    /**
     * Remove all participants from error report.
     *
     * @return void
     */
    public function forceRemoveAllParticipant()
    {
        $this->participants()->forceDelete();
    }

    /**
     * Remove participants from thread by current user.
     **
     * @return void
     */
    public function removeParticipantCurrentUser()
    {
        $this->removeParticipant(auth()->id());
    }

    /**
     * Add replier as a participant
     *
     * @return void
     */
    public function addReplierAsParticipant()
    {
        $participant = ErrorReportParticipant::firstOrCreate([
            'error_report_id' => $this->id,
            'user_id' => auth()->id(),
        ]);
        $participant->last_read = new Carbon;
        $participant->save();
    }

    /**
     * @param $attributes
     * @return mixed
     */
    public function createReply($attributes)
    {
        return $this->replies()->create($attributes);
    }

    /**
     * @param $value
     */
    public function setSubjectAttribute($value)
    {
        $this->attributes['subject'] = title_case($value);
    }

    /**
     * @return string
     */
    public function getPriorityHtmlAttribute()
    {
        return self::displayPriorityByValue($this->attributes['priority'] ?? null);
    }

    /**
     * @return string
     */
    public function getStatusHtmlAttribute()
    {
        return self::displayStatusByValue($this->attributes['status'] ?? null);
    }

    /**
     * @return mixed
     */
    public function getUpdatedAgoAttribute()
    {
        $diff = $this->updated_at->diffForHumans();

        $type = $this->updated_at->__toString() !== $this->created_at->__toString() ?
            trans('nova-feedback::situations.updated') :
            trans('nova-feedback::situations.created');

        return $diff . ' ' . $type;
    }

    /**
     * @return string
     */
    public function getCreatedAtLocalizedAttribute()
    {
        return $this->created_at->formatLocalized('%d %B %Y %H:%M');
    }

    /**
     * @return bool
     */
    public function getIsSolvedAttribute()
    {
        return self::SOLVED === ($this->attributes['status'] ?? null);
    }

    /**
     * @param $value
     * @return string
     */
    public static function displayStatusByValue($value)
    {
        switch ($value) {
            case self::WAITING_RESPONSE:
                return self::htmlElement(trans('nova-feedback::situations.waiting_response'), 'danger');
            case self::ANSWERED:
                return self::htmlElement(trans('nova-feedback::situations.answered'), 'warning');
            case self::SOLVED:
                return self::htmlElement(trans('nova-feedback::situations.solved'), 'success');
            default:
                return '-';
        }
    }


    /**
     * @param $value
     * @return string
     */
    public static function displayPriorityByValue($value)
    {
        $text = self::getPriorityText($value);

        switch ($value) {
            case self::PRIORITY_LOW:
                return self::htmlElement($text, 'primary');
            case self::PRIORITY_MEDIUM:
                return self::htmlElement($text, 'white');
            case self::PRIORITY_HIGH:
                return self::htmlElement($text, 'warning');
            case self::PRIORITY_URGENT:
                return self::htmlElement($text, 'danger');
            default:
                break;
        }
    }

    /**
     * @param $text
     * @param string $type
     *
     * @return string
     */
    public static function htmlElement($text, $type = 'secondary')
    {
        return sprintf('<button type="button" class="btn btn-default cursor-default pointer-events-none btn-sm btn-%2$s">%1$s</button>', $text, $type);
    }

    /**
     * @param $value
     * @return string
     */
    public static function getPriorityText($value)
    {

        switch ($value) {
            case self::PRIORITY_LOW:
                return trans('nova-feedback::priorities.low');
            case self::PRIORITY_MEDIUM:
                return trans('nova-feedback::priorities.medium');
            case self::PRIORITY_HIGH:
                return trans('nova-feedback::priorities.high');
            case self::PRIORITY_URGENT:
                return trans('nova-feedback::priorities.urgent');
            default:
                break;
        }
    }

    /**
     * @return string
     */
    public function priorityText()
    {
        return self::getPriorityText($this->attributes['priority'] ?? null);
    }

    /**
     * @return bool|void
     */
    public function markAsAnswered()
    {
        if ($this->attributes['status'] === self::ANSWERED) {
            return;
        }

        return $this->update([
            'status' => self::ANSWERED
        ]);
    }

    /**
     * @return bool|void
     */
    public function markAsOnHold()
    {
        if ($this->attributes['status'] === self::WAITING_RESPONSE) {
            return;
        }

        return $this->update([
            'status' => self::WAITING_RESPONSE
        ]);
    }

    /**
     * @return bool|void
     */
    public function markAsSolved()
    {
        if ($this->attributes['status'] === self::SOLVED) {
            return;
        }

        return $this->update([
            'status' => self::SOLVED
        ]);
    }

}
