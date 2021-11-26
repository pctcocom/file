<?php
namespace Pctco\File;
use Naucon\File\FileWriter;
use think\facade\Config;
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
}
