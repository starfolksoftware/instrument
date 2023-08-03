<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Document;

interface CreatesDocuments
{
    /**
     * Create a new document.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Document;
}
