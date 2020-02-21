<?php

namespace Uccello\EmailHistory\Widgets;


use App\User;
use Uccello\EmailHistory\Email;

use Arrilot\Widgets\AbstractWidget;
use Uccello\Core\Models\Domain;

class UserRolesWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //$user = User::find($this->config['record_id']);

        $module = ucmodule($this->config['module']);  // Récupère le module
        $recordId = $this->config['record_id']; // http://proservice.test/uccello/user/detail?id=1

         $record =    ucrecord($recordId, $module->model_class);
         $uuid = $record->uuid;

         $emails = Email::where('entity', $uuid)->get();

       // dd($emails);
        //dd($emails[0]->subject);
        // dd($uuid);
            // $record->uuid

     /*   $rolesOnDomains = collect();
        foreach (Domain::all() as $domain) {
            $rolesOnDomain = $user->rolesOnDomain($domain);

            if (count($rolesOnDomain) > 0) {
                $rolesOnDomains[$domain->name] = $rolesOnDomain;
            }
        }*/
        return view('email-history::widgets.email_history_widget', [
            'config' => $this->config,
            'domain' => ucdomain($this->config['domain']),
            'module' => ucmodule($this->config['module']),
            'data' => (object) $this->config['data'],
            'record' => $record,
            'label' => $this->config['data']->label ?? $this->config['labelForTranslation'],
            'emails' => $emails
            //'rolesOnDomains' => $rolesOnDomains
        ]);
    }
}
