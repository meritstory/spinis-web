<?php

declare(strict_types=1);

namespace App\Enum;

enum ComplaintAttachmentTypeEnum: string
{
    use EnumFromNameTrait;

    case INSTITUTION_SUBMISSION = 'institution_submission';
    case INSTITUTION_RESPONSE = 'institution_response';
    case PATIENT_ID_DOCUMENT = 'patient_id_document';
    case REPRESENTATION_PROOF = 'representation_proof';

    /** @return array<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
