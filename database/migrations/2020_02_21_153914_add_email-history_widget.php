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
        $widget = Widget::create([
            'label' => 'widget.email-history',
            'type' => 'summary',
            'class' => 'Uccello\EmailHistory\Widgets\EmailHistoryWidget',
            'data' => null
        ]);

        // Link the widget to the Account module
        $module = Module::where('name', 'user')->first();
        $module->widgets()->attach($widget->id, [ 'sequence' => 0]);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Widget::where('label', 'widget.email-history')
            ->where('type', 'summary')
            ->where('class', 'Uccello\EmailHistory\Widgets\EmailHistoryWidget')->delete();
    }
}
