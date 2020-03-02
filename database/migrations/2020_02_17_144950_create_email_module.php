<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Uccello\Core\Database\Migrations\Migration;
use Uccello\Core\Models\Module;
use Uccello\Core\Models\Domain;
use Uccello\Core\Models\Tab;
use Uccello\Core\Models\Block;
use Uccello\Core\Models\Field;
use Uccello\Core\Models\Filter;
use Uccello\Core\Models\Relatedlist;
use Uccello\Core\Models\Link;

class CreateEmailModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable();
        $module = $this->createModule();
        $this->activateModuleOnDomains($module);
        $this->createTabsBlocksFields($module);
        $this->createFilters($module);
        $this->createRelatedLists($module);
        $this->createLinks($module);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop table
        Schema::dropIfExists($this->tablePrefix . 'emails');

        // Delete module
        Module::where('name', 'email')->forceDelete();
    }

    protected function initTablePrefix()
    {
        $this->tablePrefix = 'email_history_';

        return $this->tablePrefix;
    }

    protected function createTable()
    {
        Schema::create($this->tablePrefix . 'emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->text('body')->nullable();
            $table->datetime('sent_at')->nullable();
            $table->string('to')->nullable();
            $table->string('cc')->nullable();
            $table->string('bcc')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('entity')->nullable();
            $table->text('attachment')->nullable();
            $table->unsignedInteger('domain_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('domain_id')->references('id')->on('uccello_domains');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('entity')->references('id')->on('uccello_entities');
        });
    }

    protected function createModule()
    {
        $module = Module::create([
            'name' => 'email',
            'icon' => 'email',
            'model_class' => 'Uccello\EmailHistory\Email',
            'data' => json_decode('{"package":"uccello\/email-history"}')
        ]);

        return $module;
    }

    protected function activateModuleOnDomains($module)
    {
        $domains = Domain::all();
        foreach ($domains as $domain) {
            $domain->modules()->attach($module);
        }
    }

    protected function createTabsBlocksFields($module)
    {
        // Tab tab.main
        $tab = Tab::create([
            'module_id' => $module->id,
            'label' => 'tab.main',
            'icon' => null,
            'sequence' => 0,
            'data' => null
        ]);

        // Block block.general
        $block = Block::create([
            'module_id' => $module->id,
            'tab_id' => $tab->id,
            'label' => 'block.general',
            'icon' => 'info',
            'sequence' => 0,
            'data' => null
        ]);

        // Field subject
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'subject',
            'uitype_id' => uitype('text')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => 0,
            'data' => json_decode('{"rules":"required"}')
        ]);

        // Field body
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'body',
            'uitype_id' => uitype('textarea')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => 1,
            'data' => null
        ]);

        // Field sent_at
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'sent_at',
            'uitype_id' => uitype('datetime')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => 2,
            'data' => null
        ]);

        // Field to
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'to',
            'uitype_id' => uitype('text')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => 3,
            'data' => null
        ]);

        // Field cc
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'cc',
            'uitype_id' => uitype('text')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => 4,
            'data' => null
        ]);

        // Field bcc
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'bcc',
            'uitype_id' => uitype('text')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => 5,
            'data' => null
        ]);

        // Field user
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'user',
            'uitype_id' => uitype('entity')->id,
            'displaytype_id' => displaytype('everywhere')->id,
            'sequence' => 6,
            'data' => json_decode('{"module":"user"}')
        ]);

        // Field entity
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'entity',
            'uitype_id' => uitype('text')->id,
            'displaytype_id' => displaytype('hidden')->id,
            'sequence' => 7,
            'data' => null
        ]);

        // Field attachment
        Field::create([
            'module_id' => $module->id,
            'block_id' => $block->id,
            'name' => 'attachment',
            'uitype_id' => uitype('text')->id,
            'displaytype_id' => displaytype('detail')->id,
            'sequence' => 8,
            'data' => null
        ]);
    }

    protected function createFilters($module)
    {
        // Filter
        Filter::create([
            'module_id' => $module->id,
            'domain_id' => null,
            'user_id' => null,
            'name' => 'filter.all',
            'type' => 'list',
            'columns' => [ 'subject', 'to', 'user', 'attachment', 'sent_at' ],
            'conditions' => null,
            'order' => null,
            'is_default' => true,
            'is_public' => false,
            'data' => [ 'readonly' => true ]
        ]);

    }

    protected function createRelatedLists($module)
    {
    }

    protected function createLinks($module)
    {
    }
}
