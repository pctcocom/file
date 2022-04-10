<?php
namespace Pctco\File;
use think\facade\Config;
use Naucon\File\File;
use Naucon\File\FileWriter;
class Tools{
    /** 
     ** 加载 entrance/static/template
     *  @param folder 文件夹名称
     *  @param filename 文件名称 不需要加.html
     *? @date 21/11/26 14:42
    */
    public function LoadTemplate($folder,$filename){
        $file = new FileWriter(Config::get('initialize.resources.path.load-template').DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$filename.'.html', 'r', true);

        return $file->read();
    }
    /** 
     ** 获取目录下的所有文件夹 (准备删除)
     *? @date 21/12/25 13:59
     *  @param myParam1 Explain the meaning of the parameter...
     *  @param myParam2 Explain the meaning of the parameter...
     *! @return 
     */
    public function getDirList($config){
        $config = array_merge([
            'path'  =>  app()->getRootPath().'entrance'.DIRECTORY_SEPARATOR,
            'type'  =>  'all'
        ],$config);

        $config = (Object)$config;

        if(!is_dir($config->path))return false;
       
        $arrName = [];
        $arrPath = [];
        $arrGroup = [];
        $data = scandir($config->path);
        
        

        if ($config->type === 'dir') {
            foreach ($data as $value){
                $path = $config->path.DIRECTORY_SEPARATOR.$value.DIRECTORY_SEPARATOR;
                if (is_dir($path)) {
                    if($value != '.' && $value != '..') {
                        $arrName[] = $value;
                        $arrPath[] = $path;
                        $arrGroup[$value] = $path;
                    }
                }
            } 
        }
        
        if ($config->type === 'file') {
            foreach ($data as $value){
                $path = $config->path.DIRECTORY_SEPARATOR.$value;
                if (is_file($path)) {
                    if($value != '.' && $value != '..') {
                        $arrName[] = $value;
                        $arrPath[] = $path;
                        $arrGroup[$value] = $path;
                    }
                }
            }
        }
        
        if ($config->type === 'all') {
            foreach ($data as $value){
                $path = $config->path.$value;
                if($value != '.' && $value != '..') {
                    $arrName[] = $value;
                    $arrPath[] = $path;
                    $arrGroup[$value] = $path;
                }
            }
        }
        return [
            'name'  =>  $arrName,
            'path'  =>  $arrPath,
            'group'  =>  $arrGroup
        ];
    }

    /** 
     ** 清除
     *? @date 22/03/24 15:32
     *  @param $dirs 需要操作的文件夹目录
     *  @param $folder $dirs 下的子文件夹方便遍历时使用
     *  @param $handle 处理 dirs = 清除 空目录
     *! @return Array $options
     */
    public function clear($options = []){
        $options = array_merge([
            'dirs'  =>  '',
            'folder'    =>  [],
            'handle'    =>  'dirs'
        ],$options);

        $options = (object)$options;
        
        foreach ($options->folder as $item) {
            $dirs = app()->getRootPath().$options->dirs.DIRECTORY_SEPARATOR.$item;
            if ($options->handle === 'dirs') $this->clearDirs($dirs);
        }

        return $options;
    }
    /** 
     ** 处理清除（$this->clear）的递归类
     *? @date 22/03/24 15:56
     *  @param $dirs 需要操作的文件夹目录
     */
    public function clearDirs($dirs){
        $file = new File($dirs);
        if ($file->exists()){
            foreach ($file->listAll() as $children) {
                if ($children->getBasename() === '.DS_Store')  $children->delete();
                // 判断是不是文件夹
                if ($children->isDir()) {
                    // 判断文件夹里是否有文件
                    $dirs = $children->getPathname();
                    $this->clearDirs($dirs);
                    if (count(scandir($dirs)) === 2) {
                        $children->delete();
                    }
                }
            }      
        }
    }
}
