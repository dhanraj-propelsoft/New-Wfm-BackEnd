<?php
 Route::get('organization_list', 'App\Http\Controllers\Organization\Controller\OrganizationController@findAll');
Route::post('organization_store', 'App\Http\Controllers\Organization\Controller\OrganizationController@store');
Route::get('organization_edit/{id}', 'App\Http\Controllers\Organization\Controller\OrganizationController@findById');
Route::get('getOrgMasterData', 'App\Http\Controllers\Organization\Controller\OrganizationController@getOrgMasterData');