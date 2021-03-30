<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterCron\Api;

interface TransporterCronInterface
{
    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return array
     */
    public function getCronData(): array;

    /**
     * @return string
     */
    public function getCronExpression(): string;

    /**
     * @return bool
     */
    public function isEnabled(): bool;
}
