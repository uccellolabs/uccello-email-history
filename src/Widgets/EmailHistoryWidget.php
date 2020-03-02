<?php

namespace Uccello\EmailHistory\Widgets;

use Uccello\EmailHistory\Email;

use Arrilot\Widgets\AbstractWidget;

class EmailHistoryWidget extends AbstractWidget
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
        $this->config['labelForTranslation'] = trans('email-history::widget.title');

        $module = ucmodule($this->config['module']);  // Récupère le module
        $recordId = $this->config['record_id']; // http://proservice.test/uccello/user/detail?id=1

        $record =    ucrecord($recordId, $module->model_class);
        $uuid = $record->uuid;

        $emails = Email::where('entity', $uuid)->get();

        return view('email-history::widgets.email_history_widget', [
            'config' => $this->config,
            'domain' => ucdomain($this->config['domain']),
            'module' => ucmodule($this->config['module']),
            'data' => (object) $this->config['data'],
            'record' => $record,
            'label' => $this->config['data']->label ?? $this->config['labelForTranslation'],
            'emails' => $emails
        ]);
    }
}
