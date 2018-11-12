# oneindex2-in
Onedrive Directory Index

## 功能：
不用服务器空间，不走服务器流量，  

直接列onedrive目录，文件直链下载。  

## demo
[http://pan.ilt.me](http://pan.ilt.me)  

## change log:  
18-11-11: 修改2.0程序对世纪互联的支持  
18-11-11: 添加安装步骤引导  
18-11-11: 添加安装步骤引导  
18-11-11: 修复缓存问题，原程序手动刷新的缓存和和文件加载缓存名称不一致导致md5不同获取缓存不生效  
18-11-11: 添加宫格模式，图片使用懒加载  
18-11-11: 添加3.0后台管理  
  

  
  
## 需求：
1、PHP空间，PHP 5.6+ 打开curl支持  
2、onedrive business 账号 (企业版或教育版/工作或学校帐户)
3、oneindex 程序   

## 安装：
1、复制oneindex到服务器，设置` config/ `、`config/base.php` 、 `cache/` 可读写  
2、浏览器访问、绑定账号  
3、可以使用  

## 计划任务  
[可选]**推荐配置**，非必需。后台定时刷新缓存，可增加前台访问的速度  
```
# 每小时刷新一次token
0 * * * * /具体路径/php /程序具体路径/one.php token:refresh

# 每十分钟后台刷新一遍缓存
*/10 * * * * /具体路径/php /程序具体路径/one.php cache:refresh
```

## 特殊文件实现功能  
` README.md `、`HEAD.md` 、 `.password`特殊文件使用  

可以参考[https://github.com/donwa/oneindex/tree/files](https://github.com/donwa/oneindex/tree/files)  

**在文件夹底部添加说明:**  
>在onedrive的文件夹中添加` README.md `文件，使用markdown语法。  

**在文件夹头部添加说明:**  
>在onedrive的文件夹中添加`HEAD.md` 文件，使用markdown语法。  

**加密文件夹:**  
>在onedrive的文件夹中添加`.password`文件，填入密码，密码不能为空。  

## 命令行功能  
仅能在php cli模式下运行  
**清除缓存:**  
```
php one.php cache:clear
```
**刷新缓存:**  
```
php one.php cache:refresh
```
**刷新令牌:**  
```
php one.php token:refresh
```
**上传文件:**  
```
php one.php upload:file 本地文件 [onedrive文件]
```
例如：  
```
//上传demo.zip 到onedrive 根目录  
php one.php upload:file demo.zip  

//上传demo.zip 到onedrive /test/目录  
php one.php upload:file demo.zip /test/  

//上传demo.zip 到onedrive /test/目录并命名为 d.zip
php one.php upload:file demo.zip /test/d.zip  
```

## 可配置项
配置在 `config/base.php` 文件中:  

**onedrive共享的起始目录:**  
```
'onedrive_root'=> '', //默认为根目录
```  

如果想只共享onedrive下的 /document/share/ 目录  
```
'onedrive_root'=> '/document/share', //最后不带 '/'
```  
  
**去掉链接中的 /?/ :**  
需要添加apache/nginx/iis的rewrite的配置文件  
参考程序根目录下的：`.htaccess`或`nginx.conf`或`Web.config`  
```
  //在config/base.php 中
  'root_path' => '?' 
```
改为  

```
    'root_path' => '' 
```  
  
**缓存时间:**  
初步测试直链过期时间为一小时,默认设置为： 
```
  'cache_expire_time' => 3600, //缓存过期时间 /秒
  'cache_refresh_time' => 600, //缓存刷新时间 /秒
```
如果经常出现链接失效，可尝试缩短缓存时间,如:  
```
  'cache_expire_time' => 300, //缓存过期时间 /秒
  'cache_refresh_time' => 60, //缓存刷新时间 /秒
```




## Q&A:  
**Q:需要企业版或教育版的全局管理员？**  
A:不需要，全局管理员开出来的子账号就可以，不过该域名在office365必须要有管理员  

**Q:文件上传后，不能即时在程序页面显示出来？**  
A:有缓存，可以在config/base.php设置缓存时间. 或在后台刷新缓存

![](http://pan.ilt.me/Images/preview/1.png)
![](http://pan.ilt.me/Images/preview/2.png)
![](http://pan.ilt.me/Images/preview/3.png)
![](http://pan.ilt.me/Images/preview/4.png)
![](http://pan.ilt.me/Images/preview/5.png)
![](http://pan.ilt.me/Images/preview/6.png)
