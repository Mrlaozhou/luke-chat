<?php
namespace Mrlaozhou\WsChat\Entities;

use Illuminate\Database\Eloquent\Model;
use Mrlaozhou\WsChat\Entities\User\Member;
use Mrlaozhou\WsChat\Entities\User\Student;

/**
 * Class WsUser
 *
 * @package Mrlaozhou\WsChat\Entities
 *
 * @method static static find($fd)
 */
class WsUser extends Model
{
    protected $guarded          =   [

    ];

    protected $primaryKey       =   'fd';

    protected $keyType          =   'int';

    public $incrementing        =   false;

    protected $table            =   'users';

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function contactsList()
    {
        $contacts                   =   collect([]);
        switch ($this->role()) {
            case 'student':
                //  获取班主任、专业老师
                $contacts->put( 'headmasters', $this->model()->headmasters() );
                break;
            case 'headmaster':
                //  获取所有成员、学员
                $contacts->put(
                    'members',
                    static::members()
                          ->where('fd', '!=', $this->getKey())
                          ->get()
                );
                $contacts->put(
                    'students',
                    $this->model()->lessonStudents('headmaster_id')->get()
                );

                break;
            case 'guide':
                //  获取成员、学员
                $contacts->put(
                    'members',
                    static::members()
                          ->where('fd', '!=', $this->getKey())
                          ->get()
                );
                //  获取专业下学员
                
                break;
            default:
                //  Members: 获取成员
                $contacts       =   self::members()
                                        ->where( 'fd', '!=', $this->getKey() )
                                        ->get();
                break;
        }
        return $contacts;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function unreadMessage()
    {
        return Message::unreadMessage( $this->pk, $this->role() );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function members()
    {
        return static::query()
                     ->whereIn('role', ['member', 'headmaster', 'guide'])
                     ->with('withMember');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function students()
    {
        return static::query()
                     ->where('role', 'student')
                     ->with('withStudent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function withMember()
    {
        return $this->hasOne( Member::class, 'id', 'pk' )
                    ->select('id','nickname as name', 'avatar');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function withStudent()
    {
        return $this->hasOne( Student::class, 'id', 'pk' )
                    ->select('id', 'name', 'avatar');
    }

    /**
     * @return string
     */
    public function role()
    {
        return $this->role;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function getInfoAttribute($value)
    {
        return json_decode( $value, true );
    }

    /**
     * @return Member|Student|null|Model
     */
    public function model()
    {
        if( $modelEntity = $this->getModelEntity() ) {
            return $modelEntity->newQuery()->find( $this->pk );
        }
        return null;
    }

    /**
     * @return Model|mixed|null
     */
    protected function getModelEntity()
    {
        if( ($client = config('ws-chat.clients.' . $this->role())) && $client['model'] ) {
            return app($client['model']);
        }
        return null;
    }

}