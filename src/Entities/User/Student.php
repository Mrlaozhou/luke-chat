<?php
namespace Mrlaozhou\WsChat\Entities\User;

class Student extends Base
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function atPeriods()
    {
        return $this->hasManyThrough(
            Period::class, StudentInPeriod::class,
            'student_id', 'id',
            'id', 'period_id'
        )->select('course_periods.id', 'course_periods.course_id', 'course_periods.label', 'course_periods.headmaster_id');
    }

    /**
     *  获取所有所在课期的班主任
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function headmasters()
    {
        //  获取所有所在课期
        $atPeriodsDetail        =   $this->atPeriods()->with(['headmaster', 'course'])->get();
        //  班主任集合
        $headmasters            =   collect( [] );
        //  去重 -->  结构变换
        $atPeriodsDetail->unique(function ($period) {
            return $period->id;
        })
                        ->map( function (Period $period) use ($headmasters){
            if( $headmaster = $period->headmaster ) {
                $headmaster->period         =   $period->getAttributes();
                $headmaster->course         =   $period->course->toArray();
                $headmasters->push( $headmaster );
            }
        } );
        return $headmasters;
    }
}