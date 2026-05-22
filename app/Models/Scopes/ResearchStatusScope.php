<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Carbon;

class ResearchStatusScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // This scope will be applied when the model is loaded
        // We'll handle the status update in the booted method instead
    }

    /**
     * Update research status based on dates and current status
     */
    public static function updateResearchStatus(Model $model): void
    {
        $now = Carbon::now();
        
        // If status is already completed, don't change it
        if ($model->research_status === 'completed') {
            return;
        }
        
        // Check if we have start and end dates
        if ($model->start_date && $model->end_date) {
            $startDate = Carbon::parse($model->start_date);
            $endDate = Carbon::parse($model->end_date);
            
            
            // If current date is after end date, status should be 'completed'
           if ($now->gt($startDate)) {
                if ($model->research_status !== 'running') {
                    $model->research_status = 'running';
                    $model->saveQuietly(); // Save without triggering events
                }
            }
            // If current date is before start date, status should be 'pending'
            elseif ($now->lt($startDate)) {
                if ($model->research_status !== 'pending') {
                    $model->research_status = 'pending';
                    $model->saveQuietly(); // Save without triggering events
                }
            }
        }
    }
} 