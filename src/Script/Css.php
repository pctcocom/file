<?php
namespace Pctco\File\Script;
class Css{
   /**
   * 合并 .CSS 文件 并且保存一个新.css文件
   * @param array   $arr  文件数组
   * @param mixed   $filePath   文件路劲
   * @param mixed   $savePath   合并文件保存路劲和文件名称
   **/
   public static function minfy($arr,$filePath,$savePath){
      $str = '';
      $ext = strrchr($savePath,'.');
      if (!empty($arr)) {
         foreach ($arr as $v) {
            if(preg_match("/^http(s)?:\\/\\/.+/",$v)){
                $str .= file_get_contents($v.$ext'?v='.time());
            }else{
                $str .= file_get_contents('.'.$filePath.$v.$ext);
            }
         }
         $str = trim($str);
         $str = str_replace("\r\n", "\n", $str);
         $search = array("/\/\*[\d\D]*?\*\/|\t+/", "/\s+/", "/\}\s+/");
         $replace = array(null, " ", "}\n");
         $str = preg_replace($search, $replace, $str);
         $search = array("/\\;\s/", "/\s+\{\\s+/", "/\\:\s+\\#/", "/,\s+/i", "/\\:\s+\\\'/i", "/\\:\s+([0-9]+|[A-F]+)/i");
         $replace = array(";", "{", ":#", ",", ":\'", ":$1");
         $str = preg_replace($search, $replace, $str);
         $str = str_replace("\n", null, $str);
      }
      file_put_contents(getcwd().$savePath,$str);
   }
}
