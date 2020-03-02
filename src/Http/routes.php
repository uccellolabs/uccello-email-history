<?php

Route::middleware('web', 'auth')
->namespace('Uccello\EmailHistory\Http\Controllers')
->name('email_history.')
->group(function () {
    // This makes it possible to adapt the parameters according to the use or not of the multi domains
    if (!uccello()->useMultiDomains()) {
        $domainParam = '';
        $domainAndModuleParams = '{module}';
    } else {
        $domainParam = '{domain}';
        $domainAndModuleParams = '{domain}/{module}';
    }

    Route::get($domainParam.'/email/attachment/download', 'DownloadController@process')
        ->defaults('module', 'email')
        ->name('attachment.download');
});
