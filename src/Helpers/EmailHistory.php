<?php

namespace Uccello\EmailHistory\Helpers;

use Uccello\Core\Models\Domain;
use Uccello\EmailHistory\Email;

class EmailHistory
{
    public function add(Domain $domain, string $entity_uuid, string $subject, string $body, ?string $attachment, ?string $to, ?string $cc, ?string $bcc, ?string $sentAt)
    {
        return Email::create([
           'subject' => $subject,
           'body' => $body,
            'sent_at' => $sentAt,
            'to' => $to,
            'cc' => $cc,
            'bcc' => $bcc,
            'attachment' => $attachment,
            'domain_id' => $domain->id,
            'entity' => $entity_uuid
        ]);
    }

    public function addWithArray(Array $params)
    {
        return Email::create($params);
    }

}
