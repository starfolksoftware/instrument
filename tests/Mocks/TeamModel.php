<?php

namespace StarfolkSoftware\Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\TeamHasInstruments;

class TeamModel extends Model
{
    use TeamHasInstruments;

    protected $table = 'teams';
}
