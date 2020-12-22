# file

```
use Pctco\File\Script\Minfy;
/**
* @name scandir
* @describe 自动压缩目录脚本
* @param mixed $dir 脚本目录
* @param mixed $run 脚本运行目录
* @return Array [path=>'脚本路径']
**/

Minfy::scandir(
   'static/client/default/#####/'.Config::get('all.client').DS,
   '/static/run/'
);
$this->assign('path',$scandir['path']);
```

```
use Pctco\File\Script\Js;

/**
* 合并 .JS 文件 并且保存一个新.js文件
* @param array   $arr  文件数组
* @param mixed   $filePath   文件路劲
* @param mixed   $SaveName   合并文件保存路劲和文件名称
* @access
**/
Js::minfy(
   ['c/body','p/common'],
   '/static/'.Config::get('all.tpl').'/script/',
   '/static/run/'.Config::get('all.client').Config::get('all.tpl')
);
```

```
use Pctco\File\Script\Css;

/**
* 合并 .CSS 文件 并且保存一个新.css文件
* @param array   $arr  文件数组
* @param mixed   $filePath   文件路劲
* @param mixed   $savePath   合并文件保存路劲和文件名称
**/

Css::minfy(
   ['c/body','p/common'],
   '/static/'.Config::get('all.tpl').'/less/',
   '/static/run/'.Config::get('all.client').Config::get('all.tpl').css|less
);
```
