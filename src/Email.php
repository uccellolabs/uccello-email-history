<?php

namespace Uccello\EmailHistory;

use Illuminate\Database\Eloquent\SoftDeletes;
use Uccello\Core\Database\Eloquent\Model;
use Uccello\Core\Support\Traits\UccelloModule;

class Email extends Model
{
    use SoftDeletes;
    use UccelloModule;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'emails';
    protected $fillable = [
        'subject',
        'body',
        'to',
        'cc',
        'bcc',
        'user_id',
        'entity',
        'sent_at',
        'attachment',
        'domain_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'attachment' => 'object',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'sent_at'];

    protected function initTablePrefix()
    {
        $this->tablePrefix = 'email_history_';
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
    * Returns record label
    *
    * @return string
    */
    public function getRecordLabelAttribute() : string
    {
        return $this->id;
    }
}
