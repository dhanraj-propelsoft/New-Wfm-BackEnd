<?php
namespace App\Notification\Repository;

use App\Notification\Model\SmsNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notification\Model\SmsLedger;

class SmsNotificationRepository implements SmsNotificationRepositoryInterface
{

    public function findAll()
    {
        return SmsNotification::where([['status', 0 ],['retry_count','<=', 3]])->get();
    }
    public function getLatestLedgerByOrgId($organization_id)
    {
        return SmsLedger::where('organization_id',$organization_id)->latest()->first();
    }

    public function findSmsNotificationByMobileNo($mobileNo)
    {
        return SmsNotification::where([
            'to_number' => $mobileNo,
            'status' => 1
        ])->first();
    }

    public function save(SmsNotification $model)
    {
        Log::info('SmsNotificationRepository->saveSmsNotification:-Inside Try');
        try {
            $result = DB::transaction(function () use ($model) {
                $model->save();
                return [
                    'message' => pStatusSuccess(),
                    'data' => $model
                ];
            });
            Log::info('SmsNotificationRepository->saveSmsNotification:-Return Try');
            return $result;
        } catch (\Exception $e) {
            Log::info('SmsNotificationRepository->saveSmsNotification:-Return Catch');
            return [
                'message' => pStatusFailed(),
                'data' => $e
            ];
        }
    }

    public function saveSMSLedger(SmsLedger $model)
    {
        Log::info('SmsNotificationRepository->saveSMSLedger:-Inside Try');
        try {
            $result = DB::transaction(function () use ($model) {
                $model->save();
                return [
                    'message' => pStatusSuccess(),
                    'data' => $model
                ];
            });
            Log::info('SmsNotificationRepository->saveSMSLedger:-Return Try');
            return $result;
        } catch (\Exception $e) {
            Log::info('SmsNotificationRepository->saveSMSLedger:-Return Catch');
            return [
                'message' => pStatusFailed(),
                'data' => $e
            ];
        }
    }
}
