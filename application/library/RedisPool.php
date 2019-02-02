<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: hanhyu
 * Date: 18-11-6
 * Time: 上午10:37
 */
class RedisPool
{
    protected $available = true;
    /**
     * @var \Swoole\Coroutine\Channel
     */
    protected $ch;

    public function __construct()
    {
        $this->ch = new \Swoole\Coroutine\Channel(300);
    }

    /**
     * 向连接池中存入连接对象，让后面的客户端可以复用则连接。
     *
     * @param \Redis $redis
     */
    public function put(\Redis $redis): void
    {
        $this->ch->push($redis);
    }

    /**
     * 获取redis连接，如池子内有连接就取一个，连接不够则新建一个。
     * @return \Redis
     */
    public function get(): \Redis
    {
        //有空闲连接
        if ($this->available and $this->ch->stats()['queue_num'] > 0) {
            $db = $this->ch->pop(3);
            /**
             * 判断此空闲连接是否已被断开，已断开就重新请求连接，
             * 这里使用channel的pop功能就实现了一个判断池子中的连接是否超过空闲时间，如超时redis则会自动断开此连接，
             * 当ping检查连接不可用时，就丢弃此连接（pop消息时连接池就没了此连接对象）并重新建立一个新的连接对象，
             * 此功能依赖于redis的timeout参数值。
             */
            if ($db === false or $this->ping($db)) goto EOF;
            return $db;
        } else {
            EOF:
            $redis = new \Redis();
            $redis->connect(\Yaf\Registry::get('config')->cache->host, (int)\Yaf\Registry::get('config')->cache->port);
            $redis->auth(\Yaf\Registry::get('config')->cache->auth);

            return $redis;
        }
    }

    /**
     * 检查连接是否可用
     *
     * @param Redis $dbconn 数据库连接
     *
     * @return bool ping通了返回false,ping不通返回true
     */
    private function ping(Redis $dbconn): bool
    {
        try {
            $dbconn->ping();
        } catch (RedisException $e) {
            co_log($e->getMessage(), "redis pool error getMessage：");
            //co_log($e->getCode(), "redis pool error getCode：");
            return true;
        }
        return false;
    }

    public function destruct()
    {
        // 连接池销毁, 置不可用状态, 防止新的客户端进入常驻连接池, 导致服务器无法平滑退出
        $this->available = false;
        while (!$this->ch->isEmpty()) {
            $this->ch->pop();
        }
    }


}