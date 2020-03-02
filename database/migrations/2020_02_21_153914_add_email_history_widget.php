<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Uccello\Core\Models\Module;
use Uccello\Core\Models\Widget;

class AddEmailHistoryWidget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add the widget into the list of widgets
        Widget::create([
            'label' => 'widget.email_history',
            'type' => 'summary',
            'class' => 'Uccello\EmailHistory\Widgets\EmailHistoryWidget',
            'data' => null
        ]);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Widget::where('label', 'widget.email_history')
            ->where('type', 'summary')
            ->where('class', 'Uccello\EmailHistory\Widgets\EmailHistoryWidget')->delete();
    }
}
