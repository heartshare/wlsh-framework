<?php
/**
 * Created by PhpStorm.
 * User: hanhyu
 * Date: 18-11-1
 * Time: 下午5:50
 */

namespace App\Plugins;

use ProgramException;
use Yaf\{
    Registry,
    Plugin_Abstract,
    Request_Abstract,
    Response_Abstract,
};
use Exception;
use Swoole\Coroutine;

class UserInit extends Plugin_Abstract
{
    /**
     *
     * @param Request_Abstract  $request
     * @param Response_Abstract $response
     *
     * @return bool|void
     * @throws Exception
     */
    public function routerStartup(Request_Abstract $request, Response_Abstract $response)
    {
        $uri    = $request->getRequestUri() ?? '0';
        $method = $request->getMethod() ?? '0';

        $request_uri = explode('/', $request->getRequestUri());
        /**
         * $arr[1] module
         * $arr[2] controller
         * $arr[3] action
         */
        if ($uri) {
            if ($request_uri[1] == 'task') return;

            $router = Registry::get('router_filter_config')->toArray();

            $this->authToken($router[$uri]['auth'] ?? true);

            if (!isset($router[$uri])) { //请求的路由错误
                $uri = '/error/router';
            } else if ($method !== $router[$uri]['method']) { //请求的方法不正确
                $uri = '/error/method';
            } else { //转发指定的路由
                $uri = $router[$uri]['action'];
            }
            //默认转发请求的路由
            $request->setRequestUri($uri);
        }
    }

    /**
     *
     * @param Request_Abstract  $request
     * @param Response_Abstract $response
     *
     * @return bool|void
     */
    public function routerShutdown(Request_Abstract $request, Response_Abstract $response)
    {
        if (!empty($request->getRequestUri())) {
            $request_uri = explode('/', $request->getRequestUri());
            if (5 == count($request_uri)) {
                $request->controller = $request_uri[2] . '\\' . ucfirst($request_uri[3]);
                $request->action     = $request_uri[4];
            }
        }

        /*可以在这个钩子函数routerShutdown中做拦截处理，获取当前URI，以当前URI做KEY，判断是否存在该KEY的缓存，
        若存在则停止解析，直接输出页面，缓存数据页。
        或做防重复操作提交*/
        //todo 权限检查在这里，在此处加入路由权限组的钩子方法
    }

    /**
     *分发循环开始之前被触发
     *
     * @param Request_Abstract  $request
     * @param Response_Abstract $response
     *
     * @return bool|void
     */
    public function dispatchLoopStartup(Request_Abstract $request, Response_Abstract $response)
    {
    }

    /**
     * 分发之前触发
     *
     * @param Request_Abstract  $request
     * @param Response_Abstract $response
     *
     * @return bool|void
     */
    public function preDispatch(Request_Abstract $request, Response_Abstract $response)
    {
    }

    /**
     * 分发结束之后触发
     *
     * @param Request_Abstract  $request
     * @param Response_Abstract $response
     *
     * @return bool|void
     */
    public function postDispatch(Request_Abstract $request, Response_Abstract $response)
    {
    }

    /**
     * 分发循环结束之后触发
     *
     * @param Request_Abstract  $request
     * @param Response_Abstract $response
     *
     * @return bool|void
     */
    public function dispatchLoopShutdown(Request_Abstract $request, Response_Abstract $response)
    {
    }

    /**
     * 请求授权的token,过滤掉配置中不需要授权认证的路由与合法性
     *
     * @param bool $auth_flag
     *
     * @throws Exception
     */
    private function authToken(bool $auth_flag): void
    {
        //该接口是否需要token认证
        if ($auth_flag) {
            //验证授权token的合法性与过期时间
            $cid     = Coroutine::getCid();
            $headers = Registry::get('request_' . $cid)->header;
            $token   = $headers['authorization'] ?? '0';

            $res = validate_token($token);
            if (!empty($res)) {
                throw new ProgramException($res['msg'], $res['code']);
            }
        }
    }

}