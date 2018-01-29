<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use League\ISO3166\ISO3166;

class CountryCodesAlpha2Validator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $value_array = json_decode($value);

        foreach ($value_array as $value) {
            $data = [];

            try {
                $data = (new ISO3166)->alpha2($value);
            } catch (\Exception $e) {
                try {
                    $data = (new ISO3166)->alpha3($value);
                } catch (\Exception $e) {
                }
            }

            if (!$data) {
                break;
            }
        }

        if (!$data) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}