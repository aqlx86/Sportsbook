<?php

namespace SportsBook;

class StatusMap
{
    protected $statuses = [
        'closed' => 'completed',
        'opening soon' => 'opening soon',
        'ready' => 'opening soon',
        'open' => 'open',
        'running' => 'running',
        'running-pending' => 'running',
        'running-pause' => 'running',
        'closing-normal' => 'open',
        'closing' => 'running'
    ];

    protected $status;

    public function __construct($cf_status)
    {
        if (! array_key_exists($cf_status, $this->statuses))
            throw new \Exception(sprintf('invalid cf status %s', $cf_status));

        $this->status = $cf_status;
    }

    public function mb_status()
    {
        return $this->statuses[$this->status];
    }
}