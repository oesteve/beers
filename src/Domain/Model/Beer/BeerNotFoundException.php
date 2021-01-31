<?php

namespace App\Domain\Model\Beer;

class BeerNotFoundException extends \Exception
{
    public static function formId(BeerId $id): self
    {
        return new self(sprintf('Beer with id %s not found', $id->getId()));
    }
}
