<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterCron\Api;

interface CronListInterface
{
    /** @var string */
    const CRON_GROUP_NAME = 'transporter';

    /**
     * @return TransporterCronInterface[]
     */
    public function getList(): array;
}
