<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: hanhyu
 * Date: 19-1-11
 * Time: 下午5:43
 */

namespace App\Services\System;

use App\Models\Mysql\SystemMenu;

class MenuServices
{
    /**
     * @var SystemMenu
     */
    private $menu;

    public function __construct()
    {
        $this->menu = new SystemMenu();
    }

    public function getList(array $data): ?array
    {
        $res = [];
        if ($data['curr_page'] > 0) {
            $data['curr_data'] = ($data['curr_page'] - 1) * $data['page_size'];
        } else {
            $data['curr_data'] = 0;
        }

        $data['where'] = [];

        $chan = new \Swoole\Coroutine\Channel(2);
        go(function () use ($chan) { //获取总数
            try {
                $count = $this->menu->getListCount();
                $chan->push(['count' => $count]);
            } catch (\Exception $e) {
                $chan->push(['500' => $e->getMessage()]);
            }
        });
        go(function () use ($chan, $data) { //获取列表数据
            try {
                $list = $this->menu->getMenuList($data);
                $chan->push(['list' => $list]);
            } catch (\Exception $e) {
                $chan->push(['500' => $e->getMessage()]);
            }
        });

        for ($i = 0; $i < 2; $i++) {
            $res += $chan->pop(7);
            if (isset($res['500'])) {
                co_log(['exception' => $res['500']], 'getMenuListAction mysql异常');
                return null;
            }
        }
        return $res;
    }

    public function getInfo(): array
    {
        return $this->menu->getMenuInfo();
    }

    public function setMenu(array $data): int
    {
        return $this->menu->setMenu($data);
    }

    public function getMenuById(int $id): array
    {
        return $this->menu->getMenu($id);
    }

    public function editMenu(array $data): int
    {
        return $this->menu->editMenu($data);
    }

    public function delMenu(int $id): int
    {
        return $this->menu->delMenu($id);
    }

}