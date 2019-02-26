<?php
namespace Mrlaozhou\WsChat\Entities\User;

class Member extends Base
{
    /**
     *  获取所带的班级、学员
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function lessonIsHeadmaster()
    {
        return $this->hasMany( Period::class, 'headmaster_id', 'id' )
            ->select('id', 'label', 'course_id', 'headmaster_id')
            ->with('atStudents')->get();
    }

    /**
     * @param string $foreignKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessonStudents (string $foreignKey)
    {
        return $this->hasMany( Period::class, $foreignKey, 'id' )->with('atStudents');
    }
}