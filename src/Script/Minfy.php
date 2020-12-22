<?php
namespace Pctco\File\Script;
use think\Config;
use Naucon\File\File;
class Minfy{
   /**
   * @name scandir
   * @describe 自动压缩目录脚本
   * @param mixed $dir 脚本目录
   * @param mixed $run 脚本运行目录
   * @return Array
   **/
   public static function scandir($dir,$run){
      if (is_int(Config::get('all.jce'))) {
         $css = preg_replace('/#####/','less',$dir,1);
         $c = [];
         foreach (scandir(ROOT_PATH.$css) as $v) {
            $ext = strrchr($v,'.');
            if ($ext == '.css') {
               $c[] = str_replace($ext,'',$v);
            }
         }
         $js = preg_replace('/#####/','script',$dir,1);
         $j = [];
         foreach (scandir(ROOT_PATH.$js) as $v) {
            $ext = strrchr($v,'.');
            if ($ext == '.js') {
               $j[] = str_replace($ext,'',$v);
            }
         }

         $fileObject = new File(ROOT_PATH.$run);

         if ($fileObject->exists() === false) {
            $fileObject->mkdirs(); // 创建目录
         }

         $runs = $run.Config::get('all.terminal').Config::get('all.client').Config::get('all.tpl');

         \File\Script\Css::minfy(
            array_filter($c),
            '/'.$css,
            $runs
         );
         \File\Script\Js::minfy(
            array_filter($j),
            '/'.$js,
            $runs
         );
      }
      return [
         'path'   =>   $run.Config::get('all.terminal').Config::get('all.client').Config::get('all.tpl')
      ];
   }
}
