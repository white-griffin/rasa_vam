<?php

namespace App\Enums;

use App\Enums\Contracts\EnumContractInterface;

enum LoanStatuses: string implements Contracts\EnumContractInterface
{

    case ACTIVE = '1';
    case PENDING = '2';
    case SOLD = '3';
    case CANCELLED = '4';
    case EXPIRED = '5';

    public static function labels(): array
    {
        return [
            self::ACTIVE->value => 'فعال',
            self::PENDING->value => 'در انتظار',
            self::SOLD->value => 'فروخته شده',
            self::CANCELLED->value => 'لغو شده',
            self::EXPIRED->value => 'منقضی شده',
        ];
    }

    public static function englishLabels(): array
    {
        return [
            self::ACTIVE->value => 'active',
            self::PENDING->value => 'pending',
            self::SOLD->value => 'sold',
            self::CANCELLED->value => 'cancelled',
            self::EXPIRED->value => 'expired',
        ];
    }

    public static function label(string $value): ?string
    {
        return self::labels()[$value] ?? null;
    }

    public static function fromValue(string $value): ?self
    {
        return self::from($value);
    }

    public static function toKeyValueItems(): ?array
    {
        return array_map(
            fn($label, $value) => ['value' => $value, 'label' => $label],
            self::labels(),
            array_keys(self::labels())
        );
    }

}
