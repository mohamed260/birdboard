<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $old = [];


    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function Tasks()
    {
        return $this->hasMany(Task::class);
    } 

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));

    }

    public function recordActivity($description)
    {

        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges($description)
        ]);
    }

    protected function activityChanges($description)
    {
        if($description == 'updated')
        {
            return [
                'before' => array_except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
                'after' => array_except($this->getChanges(), 'created_at'),
            ];
        }
        
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

}
