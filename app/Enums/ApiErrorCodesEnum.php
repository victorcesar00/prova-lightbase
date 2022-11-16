<?php

namespace App\Enums;

use App\Enums\Enum;

abstract class ApiErrorCodesEnum extends Enum {
    const VALIDATION_ERROR = 'VALIDATION_ERROR';
    const EMPTY_OBJECT = 'EMPTY_OBJECT';
    const NOT_FOUND = 'NOT_FOUND';
}
