<?php

namespace App\Repositories;

use App\Point;

class PointRepository extends BaseRepository
{
    protected $point;

    public function __construct(Point $point)
    {
        $this->point = $point;
    }
}
