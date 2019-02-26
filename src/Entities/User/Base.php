<?php
namespace Mrlaozhou\WsChat\Entities\User;

use Illuminate\Database\Eloquent\Model;

abstract class Base extends Model
{
    protected $connection       =   'crm2';

}