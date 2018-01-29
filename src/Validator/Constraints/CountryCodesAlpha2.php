<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CountryCodesAlpha2 extends Constraint
{
    public $message = '
        The string "{{ string }}" contains an wrong country codes.
        "ISO 3166-1 alpha-2/alpha-3" format must be used!
    ';
}