<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024 GT+ Logistics.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301
 * USA
 */

namespace Gtlogistics\EdiX12\Schema\Types;

final readonly class EnumType implements TypeInterface
{
    /**
     * @param array<string, string> $availableValues
     */
    public function __construct(
        private string $name,
        private array $availableValues,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return 'string'
     */
    public function getNativeType(): string
    {
        return 'string';
    }

    /**
     * @return array<string, string>
     */
    public function getAvailableValues(): array
    {
        return $this->availableValues;
    }
}
