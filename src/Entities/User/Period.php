<?php
namespace Mrlaozhou\WsChat\Entities\User;

class Period extends Base
{
    protected $table            =   'course_periods';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function course()
    {
        return $this->hasOne( Course::class, 'id', 'course_id' )
            ->select('id', 'label', 'coverImg', 'major', 'type', 'category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function headmaster()
    {
        return $this->hasOne( Member::class, 'id', 'headmaster_id' )
            ->select('id', 'nickname as name', 'email', 'avatar');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function atStudents()
    {
        return $this->hasManyThrough(
            Student::class, StudentInPeriod::class ,
            'period_id', 'id',
            'id', 'student_id'
        );
    }
}