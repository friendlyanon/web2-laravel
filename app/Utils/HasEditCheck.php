<?php

namespace App\Utils;

trait HasEditCheck
{
    /** @return boolean */
    public function canBeEdited()
    {
        return true;
    }
}
