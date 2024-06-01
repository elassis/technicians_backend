<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Ranking;
use App\Technician_profession;
use App\Profession;
use App\Job;

class Technician extends Model
{
  protected $fillable = ['user_id', 'available'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function ranking()
  {
    return $this->hasMany(Ranking::class);
  }

  public function getRankingAvg()
  {
    $rankingAvg = 0;
    foreach ($this->ranking as $rank) {
      $rankingAvg += $rank->job_ranking;
    }

    return count($this->ranking) > 0 ? $rankingAvg / count($this->ranking) :
      $rankingAvg;
  }

  public function professions()
  {
    return $this->belongsToMany(Profession::class, 'technician_professions');
  }

  public function technicianProfession()
  {
    return $this->hasMany(Technician_profession::class);
  }

  public function jobs()
  {
    return $this->hasMany(Job::class);
  }

  public function getProfessionsData()
  {
    $professionsArr = [];
    // TODO - REFACTOR THIS
    foreach ($this->professions as $profession) {
      $professionObj = [
        'id' => $profession->id,
        'tp_id' => Technician_profession::where('technician_id', $this->id)
          ->where('profession_id', $profession->id)->first()->id,
        'name' => $profession->name,
        //TODO - refactor
        'price' => Technician_profession::where('technician_id', $this->id)
          ->where('profession_id', $profession->id)->first()->price_hour,
      ];
      $professionsArr[] = $professionObj;
    }

    return $professionsArr;
  }

  public function getJobsData()
  {
    $JobsArr = [];

    foreach ($this->jobs as $job) {
      $jobObj = [
        'id' => $job->id,
        'status' => $job->status,
        'message' => $job->text,
        'profession' => $job->profession->name ?? null,
        'ranking' => $job->job_ranking,
        'comments' => $job->comments,
        'begin_date' => $job->begin_date,
        'end_date' => $job->end_date,

      ];
      $JobsArr[] = $jobObj;
    }

    return $JobsArr;
  }
}
