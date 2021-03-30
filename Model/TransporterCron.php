<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterCron\Model;

use Websolute\TransporterBase\Exception\TransporterException;
use Websolute\TransporterCron\Api\CronConfigInterface;
use Websolute\TransporterCron\Api\CronInstanceInterface;
use Websolute\TransporterCron\Api\TransporterCronInterface;

class TransporterCron implements TransporterCronInterface
{
    /**
     * @var CronConfigInterface
     */
    private $config;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $instanceName;

    /**
     * @var string
     */
    private $cronExpression;

    /**
     * @param CronConfigInterface $config
     * @param string $instanceName
     * @param string $code
     * @param string $name
     * @throws TransporterException
     */
    public function __construct(
        CronConfigInterface $config,
        string $instanceName,
        string $code,
        string $name
    ) {
        $this->config = $config;
        $this->instanceName = $instanceName;
        $this->cronExpression = $this->getCronExpression();
        $this->code = $code;
        $this->name = $name;
        if (!$this->isValid()) {
            throw new TransporterException(__('Invalid Transporter Cron'));
        }
    }

    /**
     * @return string
     */
    public function getCronExpression(): string
    {
        return $this->config->getCronExpression();
    }

    private function isValid(): bool
    {
        if (!preg_match(
            "/^(\*|([0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])|\*\/([0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])) (\*|([0-9]|1[0-9]|2[0-3])|\*\/([0-9]|1[0-9]|2[0-3])) (\*|([1-9]|1[0-9]|2[0-9]|3[0-1])|\*\/([1-9]|1[0-9]|2[0-9]|3[0-1])) (\*|([1-9]|1[0-2])|\*\/([1-9]|1[0-2])) (\*|([0-6])|\*\/([0-6]))$/",
            $this->cronExpression
        )) {
            return false;
        }

        if ($this->code === '') {
            return false;
        }
        if ($this->name === '') {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->config->isCronEnabled();
    }

    /**
     * @return array
     */
    public function getCronData(): array
    {
        return [
            'name' => $this->name,
            'instance' => $this->instanceName,
            'method' => 'execute',
            'schedule' => $this->cronExpression
        ];
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}
