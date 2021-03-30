<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterCron\Api;

interface CronInstanceInterface
{
    /**
     * @return mixed
     */
    public function execute();
}
