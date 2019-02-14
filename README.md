# wlsh-framework

> 名词解释：wlsh（ 为了生活---每个字的第一个拼音 ）

酷毙的码农为了生活自由，基于composer整合yaf框架与swoole等扩展组合而成的php内存长驻框架
，低耦合，使用非常少的语法糖，尽量使用原有扩展中的语法，提供最优状态以减少PHPer学习新框架的成本。

| 分类 | 说明 |
| :------ | :------ |
官网|https://www.wlsh.site
文档|http://doc.wlsh.site
联系邮箱|hanhyu@qq.com

### wlsh组件容器启动说明

* 1、启动docker start base_frame

* 2、启动docker start base_mysql_8.0

* 3、启动docker start base_redis_5.0

* 4、宿主机的mysql的3307映射base_mysql_8.0中的3306

* 5、宿主机的redis的6380映射base_redis_5.0中的6379

> 后面会放出组件扩展的整套docker服务运行环境

### 使用基本要求

对于使用wlsh项目的开发者，需要掌握swoole基本的开发理念与yaf框架生命周期，熟悉composer用法;对于这三点要求，我想PHPer应很容易达到。

> wlsh启动最低要求：必须已安装php 7.3、yaf 3.0.8、swoole 4.2.12、redis-5.0、mysql-8.0、inotify扩展等。

> 我们的口号是：简单才是php美之所在，用最简捷、最高效、最性价比的方式获取项目资金中的利润最大化，绝对不会增加phper的学习成本。

> wlsh组件已经历了四年时间的考验与N个线上项目的蹂躏。

### 框架特色

* 1、最低php7.3版本的支持

* 2、可无缝同步升级swoole最新版本

* 3、完全组件化

* 4、框架只定义了一个入口两个核心，其他流程都是使用方团队自己约定

* 5、基于yaf与swoole扩展组件，核心都是c扩展，其实wlsh不能叫做一个框架而是一个协程组件

* 6、简约快速,核心没有复杂化的流程

* 7、安全，团队个性化定制、一个项目可以设定自己的一套框架流程

* 8、php协程框架，在密集IO方面不低于golang、c++的处理性能

* 9、非常低耦合、完全没有新的语法糖，无依赖性

### 安装

git clone https://github.com/hanhyu/wlsh-framework.git  
或
composer create-project hanhyu/wlsh-framework wlsh dev-master

### 怎样使用？ 请参照自带的System模块代码开发流程：
![alt text](/tests/testImages/2019-02-02.png)

### 统一接口响应数据结构

```
{
    "code": 200,
    "uri": "ws/index/login",
    "data": {
        "uid": "1",
        "content": "你好，wlsh。",
        "time": "2018-10-15 21:37:37"
    }
}
```

> code字段是返回状态码，200表示成功；uri字段是供ws协议路由使用; data字段是项目提供的业务数据，由接口开发人员定义。

* 返回状态码 code
> 返回状态码code，用于表示接口响应的情况。参照自HTTP的状态码，code主要分为四大类：正常响应、重定向、非法请求与客户端参数验证错误、服务器错误。

| 分类 | code值 | 说明 |
| :------| ------ | :------ |
| 正常响应 | 200 | 表示接口服务正常响应 |
| 重定向 | 300 | 表示重定向 |
| 非法请求 | 400 | 表示客户端请求路由非法或请求参数错误 |
| 服务器错误 | 500 | 表示服务器内部错误 |

> 正常响应时，通常返回code = 200，并且同时返回data部分的业务数据，以便客户端能实现所需要的业务功能。

* 路由数据 uri
> 路由数据uri字段是供ws协议路由使用，由接口开发人员双方自定义数据内容。

* 业务数据 data
> 业务数据data为接口和客户端主要沟通对接的数据部分，可以为任何类型，由接口开发人员定义。


```
{
    "code": 400,
    "data":"用户名或密码错误"
}
```

#### 启动说明：

接口文档需要配置解析到根目录下apidoc目录中即可。

* 启动服务（根目录下执行命令）： php swoole.php start         （每次启动服务前使用该命令做预检）

* 启动服务（根目录下执行命令）： php swoole.php start -d      （以守护进程方式启动，生产环境使用）

* 启动服务（根目录下执行命令）： php swoole.php start dev     （开启debug模式，本地开发环境使用）

* 启动服务（根目录下执行命令）： php swoole.php start dev -d  （以守护进程方式启动debug模式，线上开发环境与测试环境使用）

* 停止服务（根目录下执行命令）： php swoole.php stop

> 生成在线接口文档命令（根目录下执行）：  apidoc -i application/ -o apidoc/

目录application/library/Server.php 该类是项目的核心所在，基于swoole的服务器，可同时处理websocket、http、tcp、udp等协议,
如需增加其他协议还可以同时开启监听多个协议端口,实现只需启动一个入口文件就可以处理多种协议状态；框架路由部分转交给yaf框架完成操作。

### 运维平台
自带一个默认的运维平台前端代码（vue、layui），供学习参考框架使用方法。


### 扩展

baseFrame项目中初始状态只加入了一个基本PHP数据库框架（medoo）与日志库（monolog）两个扩展; 其他扩展可根据自己
使用的场景不同用composer require 安装自己想用的扩展。

> 推荐使用awesome-php中所列出的PHP资源，其对应的中文翻译列表：<http://www.cnblogs.com/taletao/p/4212916.html/>

### 测试

wlsh-framework集成了swoole client, swoole http client, swoole websocket client连接服务器测试方法

```
/**
 * 测试文件使用方法
 * 进入tests目录
 * 在命令行中执行： php client.php  TestClient  websocket  index/index  进行websocket客户端测试
 * 在命令行中执行： php client.php  TestClient  http       index/index  进行http客户端测试
 * 执行命令参数说明：第1个为文件路径  第2个为类名  第3个为方法  第4个为路由URL
 * 在其他目录下执行,第一个文件路径参数必须为绝对目录. 如: php /var/www/wlsh-framework/tests/client.php TestClient http index/index
 */
 
测试数据库请自行按修改yaf中的数据库连接配置信息，项目根目录下自带了一份备份测试数据，可以导入进自己的mysql库中使用。
```

### 注意事项

```
本框架是协程服务框架，使用时需时刻注意swoole的协程特性给代码会来什么样的运行逻辑效果。
```
* 1、需要日志记录时用co_log()方法记录日志，该方法是协程方式处理日志。

* 2、task_log方法使用swoole的task扩展进行异步非阻塞方式记录日志，该方法是处理耗时的日志任务，如：发送邮件。

* 3、数据模型中所有的Model需要继承各自文件中AbstractModel抽象类，该类中实现了从数据协程连接池中自动获取一个连接后使用，等使用完后立即自动返回池子中;
Model中的方法如有需要用到数据库连接对象时都必须设置为protected受保护类型，这样外层在正常调用数据方法操作时，会自动先请求AbstractModel中的
call魔术方法进行连接池操作的业务分流。

* 4、 修改swoole.php、application/library/Server.php与AutoReload.php三个文件需要手动重启框架服务，其他文件修改时会框架自动重载。

（忽略）以下是框架自带的system模块约定：

* 5、暴露给前端的字段都不含表名前缀;
如： insert、update、delete:表名是base_config,在前端传name、content等字段，后端接口在model层把传入的参数做一一对应转换（加表前缀）
configName、configContent。
select:表名是base_config,后端接口在model层把查询的字段做一一对应转换（去掉表前缀）configName as name、configContent as content，再传给前端。

* 6、由于在服务核心文件中使用了Throwable捕获异常，所以在程序运行中没有catch住的异常都会在最上层捕获，在关闭调试模式下会返回500服务异常提示。

* 7、按照psr标准：变量和公共函数使用下划线，类中方法使用小写驼峰，类使用大写驼峰。

### 更多文档说明请参考[wlsh.site](https://wlsh.site) 文档，等抽空一一说明。

> workerProcess与taskProcess可以理解为ADM模式的A与D层的关系，同时也有点像传统的controllers与services层的关系,但又有本质的区别：
不同进程之间的调度关系，

### 以下是引入phalapi框架的一段说明

# Domain领域业务层与ADM模式解说

PhalApi使用的是ADM分层模式，Domain是连接Api层与Model层的桥梁。

## 何为Api-Domain-Model模式？

在传统Web框架中，惯用MVC模式。可以说，MVC模式是使用最为广泛的模式，但同时也可能是误解最多的模式。然而，接口服务这一领域，与传统的Web应用所面向的领域和需要解决的问题不同，最为明显的是接口服务领域中没有View视图。如果把MVC模式生搬硬套到接口服务领域，不但会产生更多对MVC模式的误解，还不利于实际接口服务项目的开发和交付。  

仔细深入地再思考一番，接口服务除了需要处理输入和输出，以及从持久化的存储媒介中提取、保存、删除、更新数据外，还有一个相当重要且不容忽视的任务——处理特定领域的业务规则。而这些规则的处理几乎都是逻辑层面上对数据信息的加工、转换、处理等操作，以满足特定场景的业务需求。对于这些看不见，摸不着，听不到的领域规则处理，却具备着交付有价值的业务功能的使命，与此同时也是最为容易出现问题，产生线上故障，引发损失的危险区。所以，在接口服务过程中，我们应该把这些领域业务规则的处理，把这些受市场变化而频繁变动的热区，单独封装成一层，并配套完备的自动化测试体系，保证核心业务的稳定性。  

基于以上考虑，在MVC模式的基础上，我们去掉了View视图层，添加了Domain领域业务层。从而涌现了Api-Domain-Model模式，简称ADM模式。  

简单来说，  

 + **Api层**   称为接口服务层，负责对客户端的请求进行响应，处理接收客户端传递的参数，进行高层决策并对领域业务层进行调度，最后将处理结果返回给客户端。  

 + **Domain层**   称为领域业务层，负责对领域业务的规则处理，重点关注对数据的逻辑处理、转换和加工，封装并体现特定领域业务的规则。  

 + **Model层**   称为数据模型层，负责技术层面上对数据信息的提取、存储、更新和删除等操作，数据可来自内存，也可以来自持久化存储媒介，甚至可以是来自外部第三方系统。  

## 专注领域的Domain业务层

Domain领域业务层，主要关注的是领域业务规则的处理。在这一层，不应过多关注外界客户端接口调用的签名验证、参数获取、安全性等问题，也不应过多考虑数据从何而来、存放于何处，而是着重关注对领域业务数据的处理。  

## ADM职责划分与调用关系

传统的接口开发，由于没有很好的分层结构，而且热衷于在一个文件里面完成绝大部分事情，最终导致了臃肿漫长的代码，也就是通常所说的意大利面条式的代码。  
  
在PhalApi中，我们针对接口领域开发，提供了新的分层思想：Api-Domain-Model模式。即便这样，如果项目在实际开发中，仍然使用原来的做法，纵使再好的接口开发框架，也还是会退化到原来的局面。    
  
为了能让大家更为明确Api接口层的职责所在，我们建议：  
  
Api接口服务层应该做：  

 + 应该：对用户登录态进行必要的检测
 + 应该：控制业务场景的主流程，创建领域业务实例，并进行调用
 + 应该：进行必要的日记纪录
 + 应该：返回接口结果
 + 应该：调度领域业务层
  
Api接口服务层不应该做：  

 + 不应该：进行业务规则的处理或者计算
 + 不应该：关心数据是否使用缓存，或进行缓存相关的直接操作
 + 不应该：直接操作数据库
 + 不应该：将多个接口合并在一起
   
Domain领域业务层应该做：  

 + 应该：体现特定领域的业务规则  
 + 应该：对数据进行逻辑上的处理  
 + 应该：调度数据模型层或其他领域业务层

Domain领域业务层不应该做：  

 + 不应该：直接实现数据的操作，如添加并实现缓存机制  

Model数据模型层应该：  

 + 应该：进行数据库的操作
 + 应该：实现缓存机制  


在明确了上面应该做的和不应该做的，并且也完成了接口的定义，还有验收测序驱动开发的场景准备后，相信这时，即使是新手也可以编写出高质量的接口代码。因为他会受到约束，他知道他需要做什么，主要他按照限定的开发流程和约定稍加努力即可。  
  
如果真的这样，相信我们也就慢慢能体会到精益开发的乐趣。  

至于调用关系，整体上讲，应根据从Api接口层、Domain领域层再到Model数据源层的顺序进行开发。  
  
在开发过程中，需要注意不能**越层调用**也不能**逆向调用**，即不能Api调用Model。而应该是**上层调用下层，或者同层级调用**，也就是说，我们应该：
  
 + Api层调用Domain层
 + Domain层调用Domain层
 + Domain层调用Model层
 + Model层调用Model层
   
如果用一张图来表示，则是：  

![](http://cdn7.phalapi.net/ch-2-api-domain-model-call.png)

  
为了更明确调用的关系，以下调用是**错误**的：  
  
 + 错误的做法1：Api层直接调用Model层
 + 错误的做法2: Domain层调用Api层，也不应用将Api层对象传递给Domain层
 + 错误的做法3: Model层调用Domain层 
   
#### 这样的约定，便于我们形成统一的开发规范，降低学习维护成本。比如需要添加缓存，我们知道应该定位到Model层数据源进行扩展；若发现业务规则处理不当，则应该进入Domain层探其究竟；如果需要对接口的参数进行调整，即使是新手也知道应该找到对应的Api文件进行改动。  


