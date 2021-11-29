<?php

namespace App\Observers;

use App\Models\Project;
use Illuminate\Support\Str;

class ProjectObserver
{
    public function creating(Project $project)
    {
        do {
            $slug = Str::slug($project->name).'-'. Str::random(12);
        } while(Project::where('slug', $slug)->count() === 0);
        
        $project->slug = $slug;
    }
    public function created(Project $project)
    {
        
    }
   

   
    public function updated(Project $project)
    {
        //
    }

   
    public function deleted(Project $project)
    {
        //
    }

    
    public function restored(Project $project)
    {
        //
    }

    public function forceDeleted(Project $project)
    {
        //
    }
}
