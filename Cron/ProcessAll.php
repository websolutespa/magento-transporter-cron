<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterCron\Cron;

use Exception;
use Monolog\Logger;
use Websolute\TransporterActivity\Model\HasRunningActivity;
use Websolute\TransporterBase\Model\Action\DownloadAction;
use Websolute\TransporterBase\Model\Action\ManipulateAction;
use Websolute\TransporterBase\Model\Action\UploadAction;
use Websolute\TransporterCron\Api\CronInstanceInterface;

class ProcessAll implements CronInstanceInterface
{
    /**
     * @var string
     */
    private $activityType;

    /**
     * @var DownloadAction
     */
    private $downloadAction;

    /**
     * @var ManipulateAction
     */
    private $manipulateAction;

    /**
     * @var UploadAction
     */
    private $uploadAction;

    /**
     * @var HasRunningActivity
     */
    private $hasRunningActivity;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param DownloadAction $downloadAction
     * @param ManipulateAction $manipulateAction
     * @param UploadAction $uploadAction
     * @param HasRunningActivity $hasRunningActivity
     * @param Logger $logger
     * @param string $activityType
     */
    public function __construct(
        DownloadAction $downloadAction,
        ManipulateAction $manipulateAction,
        UploadAction $uploadAction,
        HasRunningActivity $hasRunningActivity,
        Logger $logger,
        string $activityType
    ) {
        $this->downloadAction = $downloadAction;
        $this->manipulateAction = $manipulateAction;
        $this->uploadAction = $uploadAction;
        $this->activityType = $activityType;
        $this->hasRunningActivity = $hasRunningActivity;
        $this->logger = $logger;
    }

    public function execute()
    {
        try {
            if (!$this->hasRunningActivity->hasDownloading($this->activityType)) {
                $this->downloadAction->execute($this->activityType);
            } else {
                $this->logger->error(__(
                    'Cron ~ There are running downloadAction ~ activityType:%1 ~ SKIP',
                    $this->activityType
                ));
            }
        } catch (Exception $e) {
            $this->logger->error(__(
                'Cron ~ Error during downloadAction ~ activityType:%1 ~ error:%2',
                $this->activityType,
                $e->getMessage()
            ));
        }
        try {
            if (!$this->hasRunningActivity->hasManipulating($this->activityType)) {
                $this->manipulateAction->execute($this->activityType);
            } else {
                $this->logger->error(__(
                    'Cron ~ There are running downloadAction ~ activityType:%1 ~ SKIP',
                    $this->activityType
                ));
            }
        } catch (Exception $e) {
            $this->logger->error(__(
                'Cron ~ Error during manipulateAction ~ activityType:%1 ~ error:%2',
                $this->activityType,
                $e->getMessage()
            ));
        }
        try {
            if (!$this->hasRunningActivity->hasUploading($this->activityType)) {
                $this->uploadAction->execute($this->activityType);
            } else {
                $this->logger->error(__(
                    'Cron ~ There are running downloadAction ~ activityType:%1 ~ SKIP',
                    $this->activityType
                ));
            }
        } catch (Exception $e) {
            $this->logger->error(__(
                'Cron ~ Error during uploadAction ~ activityType:%1 ~ error:%2',
                $this->activityType,
                $e->getMessage()
            ));
        }
    }
}
