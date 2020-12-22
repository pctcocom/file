# file

## Script
```
/entrance/static/config.json;

{
   "cache" : true, // 重新生成所有脚本文件
   "name": {
      "index": "index",
      "admin": "admin-stop"
   },
   "library": {
      "frame": {
         "jquery": "3.5.1", //生成单个版本
         "bootstrap": [ //生成多个版本
            "3.3.5-stop", // 停止制造 如果 cache == true , stop 则无效
            "3.3.6"
         ]
      }
   }
}
```

```
use Pctco\File\Script\Format;

/**
* 制作css、less、js脚本文件
* @param array $initialize  载入config $initialize
* @return
**/
Format::making($initialize)
```

```
/**
* 压缩多个脚本
* @param array   $arr  文件数组
* @param mixed   $path   文件路劲
* @param mixed   $save   保存文件名称
* @return String
**/
Format::Compression(arr,path,$save);
```
