<?php

namespace MatviiB\Scheduler;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scheduler extends Model
{
    use SoftDeletes;

    /**
     * Define database table for service.
     *
     * @var
     */
    protected $table;

    /**
     * The attributes that can be changed by user.
     *
     * @var array
     */
    protected $fillable = ['command', 'default_parameters', 'arguments', 'options',
        'is_active', 'expression', 'description', 'last_execution', 'without_overlapping', ];

    /**
     * Scheduler constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->table = config('scheduler.table');
    }

    /**
     * Get default parameters for command execution.
     *
     * @return array
     */
    public function getDefaultParamsAttribute()
    {
        $params = [];

        if ($this->default_parameters) {
            $pairs = explode(' ', $this->default_parameters);

            foreach ($pairs as $pair) {
                $pair = explode('=', $pair);
                $params[$pair[0]] = $pair[1];
            }
        }

        return $params;
    }
}
