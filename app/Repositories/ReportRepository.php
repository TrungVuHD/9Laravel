<?php

namespace App\Repositories;

use App\Report;

class ReportRepository extends BaseRepository {
    protected $report;

    public function __construct(Report $report)
    {
       $this->report = $report;
    }
}
