<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\TaskList;
use Carbon\Carbon;

/**
 * App\Task
 *
 * @property int $id
 * @property int|null $task_list_id
 * @property string $name
 * @property int $done Is the task done
 * @property \Carbon\Carbon|null $completed_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\TaskList|null $taskList
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task completed($completed = true)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Task onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereTaskListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Task withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Task withoutTrashed()
 * @mixin \Eloquent
 */
class Task extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'task_list_id',
        'done',
        'completed_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'completed_at',
        'deleted_at'
    ];

    /**
     * Map .xls columns to model attributes
     *
     * @var array
     */
    const XLS_ATTRIBUTE_MAP = [
        'name'      => 'name',
        'completed' => 'done',
        'created_at'   => 'created_at',
        'completed_at' => 'completed_at',
    ];

    /**
     * Get Task List
     */
    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }

    /**
     * Scope for completed and not_completed tasks
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param bool $completed
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query, $completed = true)
    {
        return $query->where('done', $completed);
    }

    /**
     * Set task as complete
     * @return bool
     */
    public function setCompleted()
    {
        return $this->update(['done' => 1, 'completed_at' => Carbon::now()]);
    }

}
