<?php
declare(strict_types=1);

namespace App\Library;

use Swoole\Coroutine;
use Swoole\WebSocket\Server;

trait TaskTrait
{
    protected Server $server;
    protected array $data;
    protected int $cid;

    public function beforeInit(): void
    {
        $this->cid    = Coroutine::getCid();
        $this->data   = DI::get('task_data_arr' . $this->cid);
        $this->server = DI::get('server_obj');
    }

}
