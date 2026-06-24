<?php

namespace App\Enums;

use App\Enums\Contracts\EnumContractInterface;

enum BankServiceRequestStatuses:string implements Contracts\EnumContractInterface
{

    case PENDING = '1';
    case IN_REVIEW = '2';
    case IN_PROCESS = '3';
    case DONE = '4';
    case FAILED = '5';
    case CANCELLED = '6';

    public static function labels(): array
    {
        return [
            self::PENDING->value => 'در انتظار',
            self::IN_REVIEW->value => 'در حال بررسی',
            self::IN_PROCESS->value => 'در حال انجام',
            self::DONE->value => 'انجام شده',
            self::FAILED->value => 'ناموفق',
            self::CANCELLED->value => 'کنسل شده',
        ];
    }

    public static function englishLabels(): array
    {
        return [
            self::PENDING->value => 'pending',
            self::IN_REVIEW->value => 'in_review',
            self::IN_PROCESS->value => 'in_process',
            self::DONE->value => 'done',
            self::FAILED->value => 'failed',
            self::CANCELLED->value => 'cancelled',
        ];
    }

    public static function label(string $value): ?string  {
        return self::labels()[$value] ?? null;
    }

    public static function fromValue(string $value): ?self {
        return self::from($value);
    }

    public static function toKeyValueItems(): array {
        return array_map(
            fn($label, $value) => ['value' => $value, 'label' => $label],
            self::labels(),
            array_keys(self::labels())
        );
    }
}
