# Install
```jetpack
composer require mrlaozhou/ws-chat
```
#Config

### Laravels 配置
```jetpack
File: config/laravels.php

websocket.enable = true;
websocket.handle = \Mrlaozhou\WsChat\WsChat::class;
```

### WsChat 配置
```jetpack
File: config/ws-chat.php

clients 下配置客户端信息

```