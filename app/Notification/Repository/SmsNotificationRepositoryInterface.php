<?php
namespace App\Notification\Repository;

use App\Notification\Model\SmsNotification;
use App\Notification\Model\SmsLedger;

interface SmsNotificationRepositoryInterface
{
    public function findAll();

    public function getLatestLedgerByOrgId($organization_id);
    
    public function save(SmsNotification $model);

     public function saveSMSLedger(SmsLedger $model);

    public function findSmsNotificationByMobileNo($mobileNo);
}