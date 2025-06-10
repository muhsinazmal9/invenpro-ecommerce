<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    public const STATUS = [
        'draft' => 0,
        'sent' => 1,
        'failed' => 2,
    ];

    public const LIST = 'list_newsletter_mail';

    public const CREATE = 'create_newsletter_mail';

    public const UPDATE = 'update_newsletter_mail';

    protected $fillable = ['subject', 'body', 'status', 'receiver', 'to_all'];
}
