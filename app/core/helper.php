<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

//get common db name
if (!function_exists('pCommonDBName')) {

    /**
     * Returns a pAuthOrganizationId
     *
     * @return int or Null
     *
     */
    function pCommonDBName()
    {

        return DB::connection('mysql')->getDatabaseName();
    }
}

//get Bussiness db name
if (!function_exists('pBusinessDBName')) {

    /**
     * Returns a pAuthOrganizationId
     *
     * @return int or Null
     *
     */
    function pBusinessDBName()
    {

        return DB::connection('businessDB')->getDatabaseName();
    }
}
//get Wfm Rel Db
if (!function_exists('pWfmDBName')) {

    /**
     * Returns a pAuthOrganizationId
     *
     * @return int or Null
     *
     */
    function pWfmDBName()
    {

        return DB::connection('wfmDB')->getDatabaseName();
    }
}
//get Common Db Connection Name
if (!function_exists('pCommonDBConnectionName')) {

    /**
     * Returns a pAuthOrganizationId
     *
     * @return int or Null
     *
     */
    function pCommonDBConnectionName()
    {
        return 'mysql';
    }
}
// Get Bussiness DB Connection Name
if (!function_exists('pBusinessDBConnectionName')) {

    /**
     * Returns a pAuthOrganizationId
     *
     * @return int or Null
     *
     */
    function pBusinessDBConnectionName()
    {
        return 'businessDB';
    }
}
// Get Wfm DB Connection Name
if (!function_exists('pWfmDBConnectionName')) {

    /**
     * Returns a pAuthOrganizationId
     *
     * @return int or Null
     *
     */
    function pWfmDBConnectionName()
    {
        return 'wfmDB';
    }
}
// This function return success status
if (!function_exists('pStatusSuccess')) {

    /**
     * Returns a status string
     *
     * @return string
     *
     */
    function pStatusSuccess()
    {
        return 'SUCCESS';
    }
}

// This function return failed status
if (!function_exists('pStatusFailed')) {

    /**
     * Returns a status string
     *
     * @return string
     *
     */
    function pStatusFailed()
    {
        return 'FAILED';
    }
}
if (!function_exists('pGenarateOTP')) {
 function pGenarateOTP($num)
    {
        $x = $num - 1;

        $min = pow(10, $x);
        $max = pow(10, $x + 1) - 1;
        $value = rand($min, $max);

        return $value;
    }
}
function pSmsParser($type, $params = false)
    {
        $file = file_get_contents(base_path('assets/data/core/smsContent.json'));
        $smsContents = json_decode($file, true);

        Log::info('Helper->pSmsParser :- get requested SmsParser - ' . json_encode($smsContents));

        $smsContent = $smsContents[$type];

        if ($params && $smsContent) {
            foreach ($params as $key => $data) {
                Log::info('Helper->pSmsParser :- param key - ' . $key);
                Log::info('Helper->pSmsParser :- param value - ' . $data);
                $smsContent = str_replace($key, $data, $smsContent);
                Log::info('Helper->pSmsParser:- param value applied to the alert - ' . $smsContent);
            }
        }
        if ($smsContent) {
            return $smsContent;
        } else {
            return false;
        }
    }