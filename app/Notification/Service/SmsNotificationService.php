<?php
namespace App\Notification\Service;

use Carbon\Carbon;

use App\Notification\Model\SmsNotification;
use App\Notification\Repository\SmsNotificationRepository;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Notification\Model\SmsLedger;
//use App\Organization\Repository\OrganizationRepository;

class SmsNotificationService
{

    public function __construct(SmsNotificationRepository $repo )
    {
        $this->repo = $repo;
       // $this->orgRepo = $orgRepo;
    }

    public function createModel($mobileNo, $subject, $contentAddressedTo, $content,$organizationId = false,$category)
    {
        Log::channel('daily_job')->info('SmsNotificationService->createModel:- Inside');
        $model = new SmsNotification();
        $model->category = $category;
        $model->from_number = "11110000";
        $model->to_number = $mobileNo;
        $model->subject = $subject;
        $model->content_addressed_to = $contentAddressedTo;
        $model->content = $content;
        $model->organization_id = ($organizationId)?$organizationId:null;
        $model->status = 0; // is numberic not a string
        Log::channel('daily_job')->info('SmsNotificationService->createModel:- return' . json_encode($model));
        return $model;
    }

    public function createSmsLedgerModel($data, $balance)
    {
        Log::info('SmsNotificationService->createSmsLedgerModel:- Inside');
        $data = (object) $data;
        $model = new SmsLedger();
        $model->organization_id = $data->organization_id;
        $todayDate = date("Y-m-d");
        $model->payment_date = $todayDate;
        $model->debit = 1;
        $model->sms_notification_id = $data->sms_notification_id;
        $model->status = 2;
        $model->balance = $balance;

        Log::info('SmsNotificationService->createSmsLedgerModel:- return' . json_encode($model));
        return $model;
    }

    public function changeSentStatus($model)
    {
        Log::channel('daily_job')->info('SmsNotificationService->changeSentStatus:- Inside');
        $model->status = 1;
        Log::channel('daily_job')->info('SmsNotificationService->changeSentStatus:- Return');
        return $model;
    }

    public function save($mobileNo, $subject, $contentAddressedTo, $content,$organizationId = false,$category)
    {

        Log::channel('daily_job')->info('SmsNotificationService->save:- Inside');
        // $propelOrgId = $this->orgRepo->findByName("Propelsoft");
        // $orgId = ($organizationId)?$organizationId:$propelOrgId->id;
        $orgId = 1;

        $model = $this->createModel($mobileNo, $subject, $contentAddressedTo, $content,$organizationId,$category);
        $response = $this->repo->save($model);
        Log::channel('daily_job')->info('SmsNotificationService->save:- return');
        return $response;
    }

    public function saveSmsLedger($data)
    {
        Log::info('SmsNotificationService->saveSmsLedger:- Inside');
        $data = (object) $data;

        $latest_record =$this->repo->getLatestLedgerByOrgId($data->organization_id);
        $balance = 0;
        if ($latest_record) {
            $balance = $latest_record->balance - 1;
        }

        $model = $this->createSmsLedgerModel($data, $balance);
        $response = $this->repo->saveSmsLedger($model);
        Log::info('SmsNotificationService->saveSmsLedger:- return' . json_encode($response));
        return $response;
    }

    public function sendOutSmsNotification()
    {
        Log::channel('daily_job')->info('SmsNotificationService->sendOutSmsNotification:- Inside');
        
        $models = $this->repo->findAll();
        
        collect($models)->map(function ($model) {
            Log::channel('daily_job')->info('SmsNotificationService->sendOutSmsNotification:- $model ' . json_encode($model));
            
            try {
                
                $toMobileNo = $model->to_number;
                $message = $model->content;
                Log::channel('daily_job')->info('SmsNotificationService->sendOutSmsNotification:- message ' . json_encode($message));
                $text = rawurlencode($message);
                
                $url_1 = config('app.sms_gateway_url');
                $user = config('app.sms_gateway_username');
                $pass = config('app.sms_gateway_password');
                $sender = config('app.sms_gateway_sender');
                $priority = config('app.sms_priority');
                $smsType = config('app.sms_type');

                $url = false;
                if($model->category == "PROMOTION")
                {
                     //TODO: Need to purchase PROMOTION sms from the sms provider to send promo based sms. without that, sending promo SMS will block other SMS category as well.
                    //PROMOTION Related Sms Send This Url.
                    //$url = $url_1 . 'user=' . $user . '&pass=' . $pass . '&sender=' . $sender . '&phone=' . $toMobileNo . '&text=' . $text . '&priority=' .$priority .'&stype=' . $smsType;
                }
                else if($model->category == "OTP")
                {
                    //Otp Related Sms send this url.
                    $url = $url_1 . 'user=' . $user . '&pass=' . $pass . '&sender=' . $sender . '&phone=' . $toMobileNo . '&text=' . $text . '&priority=' .$priority .'&stype=' . $smsType;
                }
                else if($model->category == "TRANSACTION")
                {
                    //Transaction Related Sms send this url.
                    $url = $url_1 . 'user=' . $user . '&pass=' . $pass . '&sender=' . $sender . '&phone=' . $toMobileNo . '&text=' . $text . '&priority=' .$priority .'&stype=' . $smsType;
                }
                
                //$url = 'http://trans.smsfresh.co/api/sendmsg.php?user=' . $user . '&pass=' . $pass . '&sender=' . $sender . '&phone=' . $toMobileNo . '&text=' . $text . '&priority=ndnd&stype=normal';
                //$url = conf//ig('app.sms_gateway_url') . 'user=' . config('app.sms_gateway_username') . '&pass=' . config('app.sms_gateway_password') . '&sender=' . config('app.sms_gateway_sender') . '&phone=' . $toMobileNo . '&text=' . $text . '&priority=' . config('app.sms_priority') . '&stype=' . config('app.sms_type');
                Log::channel('daily_job')->info('SmsNotificationService->sendOutSmsNotification:- Success ' . $url);
                if($url){
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
                    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Connection: Keep-Alive'
                    ]);

                    $message_id = curl_exec($ch);
                    Log::channel('daily_job')->info('SmsNotificationService->sendOutSmsNotification:- message_id ' . $message_id);

                    if ($message_id) {
                        $model = $this->changeSentStatus($model);
                        $model->message_id = $message_id;
                        $data = $this->repo->save($model);
                        Log::channel('daily_job')->info('SmsNotification Service->sendOutSmsNotification:- Success ' . $model->id);

                        //update sms_ledger
                        $smsLedger =array("sms_notification_id"=>$model->id,'sms_ledger_type'=>"debit",'organization_id'=>$model->organization_id);
                        Log::channel('daily_job')->info('SmsNotificationService->sendOutSmsNotification:- sms_ledger ' .JSON_ENCODE($smsLedger));
                        $smsLedgerSave = $this->saveSmsLedger($smsLedger);

                    } else {
                        Log::channel('daily_job')->info('SmsNotificationService->sendOutSmsNotification:- failed ' . $model->id);
                        $model->error = "Failed to send out Sms to id - " . json_encode($model->to_number);
                        $model->retry_count = $model->retry_count + 1;
                        $data = $this->repo->save($model);
                    }
                }
            } catch (Exception $e) {
                Log::channel('daily_job')->info('SmsNotificationService->sendOutSmsNotification:- failed catch ' . $model->id . ' - ' . json_encode($e));
                $model->error = "Failed to send out Sms to id - " . json_encode($model->to_id) . " Reason:- " . json_encode($e);
                $model->retry_count = $model->retry_count + 1;
                $data = $this->repo->save($model);
            }
        });
            
            Log::channel('daily_job')->info('EmailNotificationService->sendOutSmsNotification:- END');
    }
}