<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterCron\Model;

use Websolute\TransporterBase\Exception\TransporterException;
use Websolute\TransporterCron\Api\CronListInterface;
use Websolute\TransporterCron\Api\TransporterCronInterface;

class CronList implements CronListInterface
{
    /**
     * @var string[]
     */
    protected $list;

    /**
     * @param array $list
     * @throws TransporterException
     */
    public function __construct(
        array $list = []
    ) {
        foreach ($list as $transporterCron) {
            if (!$transporterCron instanceof TransporterCronInterface) {
                throw new TransporterException(__("Invalid type for TransporterCron"));
            }
        }
        $this->list = $list;
    }

    /**
     * {@inheritdoc}
     */
    public function getlist(): array
    {
        return $this->list;
    }
}
