<?php
namespace Pctco\File\Script;
use think\facade\Cache;
class Format{
   private $initialize;
   function __construct($initialize){
      $this->initialize = $initialize['initialize'];
   }
   /**
   * 制作css、less、js脚本文件
   * @param array $initialize  载入config $initialize
   * @return
   **/
   public function making(){
      if ($this->initialize['env']['APP_DEBUG']) {
         // Get Config.json
         $config = json_decode(file_get_contents($this->initialize['resources']['static']['config']),true);
         $root = $this->initialize['resources']['path']['root'];

         $path = $this->initialize['resources']['path']['static'];
         $remoteDomain = $this->initialize['remote']['domain'].DIRECTORY_SEPARATOR.'static';

         $index = $library = [
            'js'   =>   [],
            'css'   =>   [],
            'less'   =>   []
         ];

         $script = [];
         $_script = Cache::store('config')->get('script');
         $theme = 'theme'.DIRECTORY_SEPARATOR.$this->initialize['template']['theme'].DIRECTORY_SEPARATOR;

         foreach ($config as $k1 => $v1) {
            switch ($k1) {
               case strstr($k1, '_'):
                  $k1 = str_replace('_','',$k1);
                  if (strrchr($k1,'-') != '-stop') {
                     foreach ($v1 as $k2 => $v2) {
                        foreach ($v2[$this->initialize['client']['type']] as $k3 => $v3) {
                           $files = $k2.DIRECTORY_SEPARATOR.$this->initialize['client']['type'].DIRECTORY_SEPARATOR.'compress'.DIRECTORY_SEPARATOR.$v3;
                           if(strrchr($v3,'.') === '.folder'){ // The local folder
                              foreach (scandir($root.$path.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR.$files) as $folder) {
                                 $ext = preg_replace('/./','',strrchr($folder,'.'),1);
                                 if (in_array($ext,array_keys($index))) {
                                    $index[$ext][] = $theme.$files.DIRECTORY_SEPARATOR.$folder;
                                 }
                              }
                           }else if(strpos($v3,'/') === false){ // The local file
                              $index[$k2][] = $theme.$files.'.'.$k2;
                           }else{ // The remote file
                              $index[$k2][] = $remoteDomain.$v3.'.'.$k2;
                           }
                        }
                        $script[$k1][$k2] =
                        $this->compression($index[$k2],$root.$path,md5($this->initialize['client']['type'].$k1).'.'.$k2);
                     }
                  }else{
                     $new_k1 = str_replace('-stop','',$k1);
                     $script[$new_k1] = $_script[$new_k1];
                  }
                  break;
               case 'library':
                  $arr = [];

                  foreach ($v1 as $types => $bank) {
                     $i = 0;
                     $c = count($bank);
                     foreach ($bank as $name => $version) {
                        if (is_array($version)) {
                           foreach ($version as $kv => $vv) {
                              if ((strrchr($vv,'-') != '-stop' && $config['cache']) || $config['sorting']) {
                                 $vv = str_replace('-stop','',$vv);
                                 $fileName = $name.'-'.$vv;
                                 $relative = DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.$types.DIRECTORY_SEPARATOR.$name.DIRECTORY_SEPARATOR.$vv.DIRECTORY_SEPARATOR;
                                 $folder = $root.$path.$relative;
                                 foreach (scandir($folder) as $files) {
                                    $ext = preg_replace('/./','',strrchr($files,'.'),1);
                                    if (in_array($ext,array_keys($library))) {
                                       $arr[$name.'-'.str_replace('.','',$vv)][$ext][] = $relative.$files;
                                    }
                                 }
                              }
                           }
                        }else{
                           if ((strrchr($version,'-') != '-stop' && $config['cache']) || $config['sorting']) {
                              $version = str_replace('-stop','',$version);
                              $fileName = $name.'-'.$version;
                              $relative = DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.$types.DIRECTORY_SEPARATOR.$name.DIRECTORY_SEPARATOR.$version.DIRECTORY_SEPARATOR;
                              $folder = $root.$path.$relative;
                              foreach (scandir($folder) as $files) {
                                 $ext = preg_replace('/./','',strrchr($files,'.'),1);
                                 if (in_array($ext,array_keys($library))) {
                                    $arr[$name.'-'.str_replace('.','',$version)][$ext][] = $relative.$files;
                                 }
                              }
                           }
                        }
                     }
                  }
                  if ($config['sorting']) {
                     foreach ($arr as $nv => $t) {
                        foreach ($t as $suffix => $array) {
                           $script[$k1][$nv][$suffix] = $this->compression($array,$root.$path,md5($nv).'.'.$suffix);
                        }
                     }
                  }else{
                     foreach ($arr as $nv => $t) {
                        foreach ($t as $suffix => $array) {
                           $_script[$k1][$nv][$suffix] = $this->compression($array,$root.$path,md5($nv).'.'.$suffix);
                        }
                     }
                     $script['library'] = $_script['library'];
                  }

                  break;
               case 'library-stop':
                  $script['library'] = $_script['library'];
                  $script['volist']['library'] = $_script['volist']['library'];
                  break;
            }
         }


         $script['volist']['library'] = $script['volist']['min'] = [];
         if ($config['min']['status'] === true) {
            if (!empty($script['library'])) {
               $minJs = $minCss = [];
               foreach ($script['library'] as $library) {
                  if (!empty($library['js'])) {
                     $script['volist']['library']['js'][] = $library['js'];
                     $minJs[] = str_replace('/static','',substr($library['js'],0,strpos($library['js'], '?')));
                  }
                  if (!empty($library['css'])) {
                     $script['volist']['library']['css'][] = $library['css'];
                     $minCss[] = str_replace('/static','',substr($library['css'],0,strpos($library['css'], '?')));
                  }
               }
               if (!empty($minJs)) {
                  $script['volist']['min']['js'][] = $this->compression($minJs,$root.$path.DIRECTORY_SEPARATOR,$config['min']['js'].'.js');
               }
               if (!empty($minCss)) {
                  $script['volist']['min']['css'][] = $this->compression($minCss,$root.$path.DIRECTORY_SEPARATOR,$config['min']['css'].'.css');
               }
            }

         }else{
            $script['volist'] = $_script['volist'];
         }

         $script['config'] = $config;

         if ($config['cache']) {
            Cache::store('config')->set('script',$script);
         }else{
            return Cache::store('config')->get('script');
         }
         return $script;
      }
      return Cache::store('config')->get('script');
   }
   /**
   * 压缩多个脚本
   * @param array   $arr  文件数组
   * @param mixed   $path   文件路劲
   * @param mixed   $save   保存文件名称
   * @return String
   **/
   public function compression($arr,$path,$save){
      $script = '';
      if (!empty($arr)) {
         foreach ($arr as $v) {
            if(preg_match("/^http(s)?:\\/\\/.+/",$v)){
                $script .= file_get_contents($v.'?v='.time());
            }else{
                $script .= file_get_contents($path.DIRECTORY_SEPARATOR.$v);
            }
         }
         if (in_array(strrchr($save,'.'),['.css','.less'])) {
            $script = trim($script);
            $script = str_replace("\r\n", "\n", $script);
            $search = array("/\/\*[\d\D]*?\*\/|\t+/", "/\s+/", "/\}\s+/");
            $replace = array(null, " ", "}\n");
            $script = preg_replace($search, $replace, $script);
            $search = array("/\\;\s/", "/\s+\{\\s+/", "/\\:\s+\\#/", "/,\s+/i", "/\\:\s+\\\'/i", "/\\:\s+([0-9]+|[A-F]+)/i");
            $replace = array(";", "{", ":#", ",", ":\'", ":$1");
            $script = preg_replace($search, $replace, $script);
            $script = str_replace("\n", null, $script);
         }else{
            $JsMin = new \Pctco\File\Script\Js($script);
            $script = $JsMin->min();
         }
         file_put_contents($path.DIRECTORY_SEPARATOR.'compression'.DIRECTORY_SEPARATOR.$save,trim($script));
         return DIRECTORY_SEPARATOR.'static'.DIRECTORY_SEPARATOR.'compression'.DIRECTORY_SEPARATOR.$save.'?'.time();
      }
   }
}
