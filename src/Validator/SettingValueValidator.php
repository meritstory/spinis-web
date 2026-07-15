<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\Setting;
use App\Enum\SettingKeyEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SettingValueValidator extends ConstraintValidator
{
    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof SettingValue) {
            throw new UnexpectedTypeException($constraint, SettingValue::class);
        }

        if (!$value instanceof Setting) {
            return;
        }

        if ($value->getValue() === '') {
            return;
        }

        if ($value->getKey() === SettingKeyEnum::REQUEST_RECIPIENT_EMAIL->value) {
            $violations = $this->validator->validate($value->getValue(), new Email(
                message: $constraint->invalidEmailMessage,
            ));

            foreach ($violations as $violation) {
                $this->context->buildViolation((string) $violation->getMessage())
                    ->atPath('value')
                    ->addViolation();
            }
        }
    }
}
