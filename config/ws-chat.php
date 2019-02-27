<?php

return [
    /*
    |--------------------------------------------------------------------------
    | 客户端
    |--------------------------------------------------------------------------
    |   -- 描述 --
    |
    */
    'clients'              =>  [
        'student'       =>  [
            'name'          =>  'student',
            'clientId'      =>  1,
            'domain'        =>  'http://192.168.1.222:8202',
            'model'         =>  \Mrlaozhou\WsChat\Entities\User\Student::class,
            'auth_key'      =>  'Authorization',
            'auth_type'     =>  'get',
            'user_api'      =>  '/api/user',
            'need_auth'     =>  true,
        ],
        'member'           =>  [
            'name'          =>  'member',
            'clientId'      =>  5,
            'domain'        =>  'http://192.168.1.222:8201',
            'model'         =>  \Mrlaozhou\WsChat\Entities\User\Member::class,
            'auth_key'      =>  'Authorization',
            'auth_type'     =>  'post',
            'user_api'      =>  '/api/profile',
            'need_auth'     =>  true,
        ],
        'headmaster'           =>  [
            'name'          =>  'headmaster',
            'clientId'      =>  5,
            'domain'        =>  'http://192.168.1.222:8201',
            'model'         =>  \Mrlaozhou\WsChat\Entities\User\Member::class,
            'auth_key'      =>  'Authorization',
            'auth_type'     =>  'post',
            'user_api'      =>  '/api/profile',
            'need_auth'     =>  true,
        ],
        'guide'           =>  [
            'name'          =>  'guide',
            'clientId'      =>  5,
            'domain'        =>  'http://192.168.1.222:8201',
            'model'         =>  \Mrlaozhou\WsChat\Entities\User\Member::class,
            'auth_key'      =>  'Authorization',
            'auth_type'     =>  'post',
            'user_api'      =>  '/api/profile',
            'need_auth'     =>  true,
        ],
    ],
];