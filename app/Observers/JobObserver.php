<?php

namespace App\Observers;

use App\Models\Job;
use App\Services\LoggingService;

class JobObserver
{
    public function created(Job $job): void
    {
        LoggingService::logCreate(
            'Job',
            $job->id,
            "New job created: {$job->job_number} - {$job->description}",
            $job->toArray()
        );
    }

    public function updated(Job $job): void
    {
        $changes = $job->getChanges();
        $statusChange = isset($changes['status']) ? " (Status: {$job->getOriginal('status')} → {$job->status})" : '';
        LoggingService::logUpdate(
            'Job',
            $job->id,
            "Job updated: {$job->job_number}{$statusChange}",
            $job->getOriginal(),
            $changes
        );
    }

    public function deleted(Job $job): void
    {
        LoggingService::logDelete(
            'Job',
            $job->id,
            "Job deleted: {$job->job_number}",
            $job->toArray()
        );
    }
}
