<?php

namespace Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Model;
use Instrument\TeamHasInstruments;

class TeamModel extends Model
{
    use TeamHasInstruments;

    protected $table = 'teams';
}
