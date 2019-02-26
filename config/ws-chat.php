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
            'domain'        =>  'http://127.0.0.1:8202',
            'model'         =>  \Mrlaozhou\WsChat\Entities\User\Student::class,
            'auth_key'      =>  'S_Authorization',
            'user_api'      =>  '/api/user',
            'need_auth'     =>  true,
        ],
        'member'           =>  [
            'name'          =>  'member',
            'clientId'      =>  5,
            'domain'        =>  'http://127.0.0.1:8201',
            'model'         =>  \Mrlaozhou\WsChat\Entities\User\Member::class,
            'auth_key'      =>  'Authorization',
            'user_api'      =>  '/api/user',
            'need_auth'     =>  true,
        ],
        'headmaster'           =>  [
            'name'          =>  'headmaster',
            'clientId'      =>  5,
            'domain'        =>  'http://127.0.0.1:8201',
            'model'         =>  \App\Models\CRM\Member::class,
            'auth_key'      =>  'Authorization',
            'user_api'      =>  '/api/user',
            'need_auth'     =>  true,
        ],
        'guide'           =>  [
            'name'          =>  'guide',
            'clientId'      =>  5,
            'domain'        =>  'http://127.0.0.1:8201',
            'model'         =>  \App\Models\CRM\Member::class,
            'auth_key'      =>  'Authorization',
            'user_api'      =>  '/api/user',
            'need_auth'     =>  true,
        ],
    ],
];