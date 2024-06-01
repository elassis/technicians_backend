<?php

namespace App\Services;

use App\Job;
use App\Ranking;

class JobService
{

    public function show($jobId)
    {
        //
        $job = Job::findOrFail($jobId);
        return $job;
    }

    public function storeCommentAndRanking($jobId, $data)
    {
        try {
            $job = Job::findOrFail($jobId);
            $job->update(['comments' => $data['comment'], 'status' => 'finished']);

            if ($job->ranking != null) {
                $job->ranking->update(['job_ranking' => $data['ranking']]);
            } else {
                $techId = $job->technician_id;
                Ranking::create([
                    'technician_id' => $techId,
                    'job_id' => $job->id,
                    'job_ranking' => $data['ranking']
                ]);
            }
        } catch (\Throwable $e) {
            return $e;
        }

        return true;
    }
}
