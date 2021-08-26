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
