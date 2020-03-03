# Email History

This package allows you to track with Uccello emails sent.

## Installation

### Install with composer

```bash
composer require uccello/email-history
```

### Publish assets

```bash
php artisan vendor:publish --tag=email-history-assets
```

## Usage

### Create Related Lists

With a migration, create a [Related List](https://uccello.gitbook.io/doc/the-basics/related-list) to display emails sent related to a record:

```bash
php artisan make:migration create_email_history_rl
```



```php
<?php

use Illuminate\Database\Migrations\Migration;
use Uccello\Core\Models\Module;
use Uccello\Core\Models\Relatedlist;

class CreateEmailHistoryRl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $module = Module::where('name', 'account')->first(); // Change 'account' with the source module's name

        $relatedModule = Module::where('name', 'email')->first();
        Relatedlist::create([
            'module_id' => $module->id,
            'related_module_id' => $relatedModule->id,
            'related_field_id' => $relatedModule->fields->where('name', 'entity')->first()->id,
            'tab_id' => null,
            'label' => 'relatedlist.emails',
            'type' => 'n-1',
            'method' => 'getDependentList',
            'sequence' => $module->relatedlists()->count(),
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
        $module = Module::where('name', 'account')->first(); // Change 'account' with the source module's name

        $relatedModule = Module::where('name', 'email')->first();
        Relatedlist::where('module_id', $module->id)
            ->where('related_module_id', $relatedModule->id)
            ->where('label', 'relatedlist.emails')
            ->delete();
    }
}

```

### Helper

A helper allows you to add easily a new email and link it to a record.

```php
<?php

    use Uccello\EmailHistory\Facades\EmailHistory;

    // Use function params
	EmailHistory::add(
        $domain, // Current domain
        $record->uuid, // Record uuid
        'Hi everyone!', // Email subject
        'A beautiful email to remember install this package', // Email body
        'friends@uccello.io', // To
        Carbon::now(), // Sent at - optional
        [ // An array with all attachments (File name => File path in storage) - optional
        "File1.pdf" => "uccello/files/zPODV1l0WF4wEJsad7xHsX6G7D7Cu004AEKjDSkd.pdf",
        "File2.pdf" => "uccello/files/zPODV1l0WF4wEJsad7xHsX6G7D7Cu004AEKjDSkd.pdf"
        ],
        'other_friends@uccello.io', // Cc - optional
        'hidden_friends@uccello.io' // Bcc - optional
    );

    // Use array
	EmailHistory::addWithArray([
        'subject' => $subject,
        'body' => $body,
        'sent_at' => $sentAt, // Optional
        'to' => $to,
        'cc' => $cc, // Optional
        'bcc' => $bcc, // Optional
        'attachment' => $attachment, // Optional
        'domain_id' => $domain->id,
        'entity' => $entity_uuid
    ])
```