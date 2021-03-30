<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterCron\Plugin;

use Magento\Cron\Model\ConfigInterface;
use Websolute\TransporterCron\Api\CronListInterface;
use Websolute\TransporterCron\Model\CronList;

class PushJobs
{
    /**
     * @var CronList
     */
    private $cronList;

    /**
     * @param CronList $cronList
     */
    public function __construct(
        CronList $cronList
    ) {
        $this->cronList = $cronList;
    }

    /**
     * @param ConfigInterface $subject
     * @param $result
     * @return mixed
     */
    public function afterGetJobs(ConfigInterface $subject, $result)
    {
        $list = $this->cronList->getlist();

        if (!count($list)) {
            return $result;
        }

        if (!array_key_exists(CronListInterface::CRON_GROUP_NAME, $result)) {
            $result[CronListInterface::CRON_GROUP_NAME] = [];
        }

        foreach ($list as $transporterCron) {
            if ($transporterCron->isEnabled()) {
                $result[CronListInterface::CRON_GROUP_NAME][$transporterCron->getCode()] = $transporterCron->getCronData();
            }
        }

        if (!count($result[CronListInterface::CRON_GROUP_NAME])) {
            unset($result[CronListInterface::CRON_GROUP_NAME]);
        }

        return $result;
    }
}
