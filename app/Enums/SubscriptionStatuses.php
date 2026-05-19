<?php

namespace App\Enums;

use App\Enums\Contracts\EnumContractInterface;

enum SubscriptionStatuses: string implements Contracts\EnumContractInterface
{

    case ACTIVE = '1';
    case EXPIRED = '2';
    case CANCELLED = '3';
    public static function labels(): array
    {
        return [
            self::ACTIVE->value => 'فعال ',
            self::EXPIRED->value => 'منقضی شده ',
            self::CANCELLED->value => 'کنسل شده'
        ];
    }

    public static function englishLabels(): array
    {
        return [
            self::ACTIVE->value => 'active',
            self::EXPIRED->value => 'expired',
            self::CANCELLED->value => 'cancelled',
        ];
    }

    public static function englishLabel(string $value): ?string
    {
        return self::englishLabels()[$value] ?? null;
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
