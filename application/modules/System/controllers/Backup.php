<?php
declare(strict_types=1);

namespace App\Modules\System\controllers;

/**
 * Created by PhpStorm.
 * User: hanhyu
 * Date: 18-11-7
 * Time: 下午11:30
 */

use App\Models\Forms\SystemUserForms;
use App\Models\Forms\SystemBackupForms;
use Exception;
use Yaf\Controller_Abstract;
use Yaf\Registry;
use App\Domain\System\Backup as BackupDomain;

//todo 数据备份类未整理完
class Backup extends Controller_Abstract
{
    use \ControllersTrait;

    public $backup_path = ''; //备份文件夹相对路径
    public $backup_name = ''; //当前备份文件夹名
    public $offset = '500'; //每次取数据条数
    public $dump_sql = '';

    /**
     * @var BackupDomain
     */
    private $backup_domain;

    public function init()
    {
        $this->beforeInit();
        $this->backup_domain = new BackupDomain();
    }

    /**
     * 获取所有数据表名
     * @throws Exception
     */
    public function indexAction(): void
    {
        $res = $this->backup_domain->getTables();
        $this->response->end(http_response(200, '', $res));
    }

    /**
     * 备份数据库
     * @throws Exception
     */
    public function addAction(): void
    {
        $data = $this->validator(SystemUserForms::$pull);
        if ($data['pwd'] == 'wlsh_frame_mysql_backup_20180107') {
            $config      = Registry::get('config');
            $host        = $config->mysql->host;
            $port        = $config->mysql->port;
            $username    = $config->mysql->username;
            $pwd         = $config->mysql->password;
            $database    = $config->mysql->database;
            $path        = $config->backup->path;
            $date        = date('Y-m-d', time());
            $rand        = time();
            $yaf_environ = ini_get('yaf.environ');
            $filename    = "{$path}/{$database}-{$yaf_environ}-{$date}-{$rand}.sql";
            $res         = \Swoole\Coroutine::exec("mysqldump -h{$host} -P{$port} -u{$username} -p{$pwd} {$database} > {$filename}");
            if ($res['code'] == 0) {
                $arr['filename'] = "{$database}-{$yaf_environ}-{$date}-{$rand}.sql";
                $arr['size']     = filesize($filename);
                $arr['md5']      = hash_file('md5', $filename);
                $arr['rand']     = $rand;
                $let             = $this->backup_domain->setBackup($arr);
                if ($let) {
                    $this->response->end(http_response());
                } else {
                    $this->response->end(http_response(400, '存入数据失败'));
                }
            } else {
                $this->response->end(http_response(400, '生成备份数据文件失败'));
            }
        } else {
            $this->response->end(http_response(400, '密码错误'));
        }
    }

    /**
     * 获取列表
     * @throws Exception
     */
    public function getListAction(): void
    {
        $data = $this->validator(SystemUserForms::$getList);
        $list = $this->backup_domain->getList($data);
        $this->response->end(http_response(200, '', $list));
    }

    /**
     * 下载数据库备份的文件
     * @throws Exception
     */
    //todo 下载链接直接在前端拼接，无需在后端操作，但是在后端操作有个好处是需要登录认证后才能下载，否则不能用url直接下载。
    public function downAction(): void
    {
        $data = $this->validator(SystemUserForms::$getUser);
        $res  = $this->backup_domain->getFileName((int)$data['id']);
        if (!empty($res)) {
            $res[0]['file_name'] = Registry::get('config')->backup->downUrl . $res[0]['file_name'];
            $this->response->end(http_response(200, '', $res[0]));
        }
    }

    /**
     * 删除备份文件
     * @throws Exception
     */
    public function delAction(): void
    {
        $data = $this->validator(SystemBackupForms::$del);

        //$id = intval($data['id'] ?? 0);
        //$fileName = strval($data['fileName'] ?? 0);
        //删除数据库备份表中的信息
        $res = $this->backup_domain->delBackup((int)$data['id']);
        if ($res) {
            $linkname = Registry::get('config')->backup->path . '/' . $data['filename'];
            if (is_file($linkname)) {
                //删除备份文件
                $unFile = unlink($linkname);
                if ($unFile) $this->response->end(http_response(200, '', ['id' => $data['id']]));
            } else {
                $this->response->end(http_response(400, "{$data['id']}-删除失败"));
            }
        } else {
            $this->response->end(http_response(400, "{$data['id']}-删除失败"));
        }
    }

}
