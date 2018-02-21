<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Task;

/**
 * App\TaskList
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property int $archive Is the task list archive
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Task[] $tasks
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskList archived($archived = true)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\TaskList onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskList whereArchive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskList whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskList whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TaskList withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\TaskList withoutTrashed()
 * @mixin \Eloquent
 */
class TaskList extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'archive'
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'user_id' => 'integer' ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // delete tasks
        static::deleting(function (self $taskList) {

            $taskList->tasks()->delete();
        });
    }

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the tasks for the list.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    
    /**
     * Scope for archived and not_archived lists
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param bool $archived
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived($query, $archived = true)
    {
        return $query->where('archive', $archived);
    }
    /**
     * Check whether the TaskList is eligible for archive with its current data
     * @return bool
     */
    public function canArchive()
    {
        return $this->tasks()->count() >= 1;
    }
    
    /**
     * Check whether the TaskList is archived
     * @return bool
     */
    public function isArchive()
    {
        return $this->archive;
    }
    /**
     * Set task_list as archived
     * @return bool
     */
    public function setArchived($archive = 1)
    {
        return $this->update(['archive' => $archive]);
    }

}
