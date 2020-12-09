<?php
namespace Pctco\Date;
use Pctco\Date\Data;
/**
 * 查询
 */
class Query{
   /**
   * @name attr
   * @describe 根据出生日期计算年龄、生肖、星座
   * @param mixed $date = "0000-00-00" 日期
   * @return Array
   **/
   public static function attr($date){
      //计算年龄
   	$birth = $date;
   	list($by,$bm,$bd) = explode('-',$birth);
   	$cm=date('n');
   	$cd=date('j');
   	$age=date('Y')-$by-1;
   	if ($cm>$bm || $cm==$bm && $cd>$bd) $age++;

   	$array['age'] = $age;

   	//计算生肖
   	$animals = Data::zodiac();
   	$key = ($by - 1900) % 12;
   	$array['animals'] = $animals[$key];

   	//计算星座
   	$constellation_name = Data::constellation();
   	if ($bd <= 22){
   		if ('1' !== $bm) $constellation = $constellation_name[$bm-2]; else $constellation = $constellation_name[11];
   	}else $constellation = $constellation_name[$bm-1];
   	$array['constellation'] = $constellation;

   	return $array;
   }
   /**
   * @name week
   * @describe 从日期中获取星期
   * @param mixed $time 时间戳
   * @return
   **/
   public static function week($time){
      $arr = explode("-",date('Y-m-d',$time));
      //参数赋值
      $year = $arr[0]; //年
      $month = sprintf('%02d',$arr[1]); //月，输出2位整型，不够2位右对齐
      $day = sprintf('%02d',$arr[2]); //日，输出2位整型，不够2位右对齐
      $hour = $minute = $second = 0; //时分秒默认赋值为0；
      //转换成时间戳
      $strap = mktime($hour,$minute,$second,$month,$day,$year);
      //获取数字型星期几
      $wk=date("w",$strap);
      //自定义星期数组
      $week = Data::week();
      //获取数字对应的星期
      return $week[$wk];
   }
   /**
   * @name countdown
   * @describe 倒计时
   * @param mixed $stamp 时间戳
   * @return Array
   **/
   public static function countdown($stamp){
      $second = $stamp - time();
      $day = floor($second/(3600*24));
      $second = $second%(3600*24);//除去整天之后剩余的时间

      $hour = floor($second/3600);
      $second = $second%3600;//除去整小时之后剩余的时间

      $minute = floor($second/60);
      $second = $second%60;//除去整分钟之后剩余的时间
      //返回字符串
      $day = $day > 9 ? $day : '0'.$day;
      $hour = $hour > 9 ? $hour : '0'.$hour;
      $minute = $minute > 9 ? $minute : '0'.$minute;
      $second = $second > 9 ? $second : '0'.$second;
      return [$day,$hour,$minute,$second];
   }
   /**
   * @name interval
   * @describe 间隔 发布文章等日期计算
   * @param mixed $time 时间戳
   * @param mixed $redata 返回时间类型  day = 天  hour = 小时
   * @param mixed $format 时间格式
   * @return
   **/
   public static function interval($time){
      $limit = time() - $time;
      $r = "";
      if($limit < 60) {
         $r = '刚刚发表';
      } elseif($limit >= 60 && $limit < 3600) {
         $r = floor($limit / 60) . '分钟前';
      } elseif($limit >= 3600 && $limit < 86400) {
         $r = floor($limit / 3600) . '小时前';
      } elseif($limit >= 86400 && $limit < 2592000) {
         $r = floor($limit / 86400) . '天前';
      } elseif($limit >= 2592000 && $limit < 31104000) {
         $r = floor($limit / 2592000) . '个月前';
      } else {
         $r = date('Y-m-d',$time);
      }
      return $r;
   }
   /**
   * @name get day
   * @describe 获取上下天数
   * @param mixed $day 获取天数
   * @param mixed $order 排序 asc/desc
   * @param mixed $time 开始时间 时间戳
   * @param mixed $format 时间格式
   * @return Array
   **/
   public static function day($day,$time,$order = 'asc',$format = 'Y-m-d'){
      $week = $order == 'asc'?date('w', $time):$day;
      $date = [];
      for ($i=1; $i<=$day; $i++){
         $date[$i] = date($format ,strtotime( '+' . $i-$week .' days', $time));
      }
      return $date;
   }
   /**
   * @name time_17
   * @describe 17位时间戳
   * @return String
   **/
   public static function time_17(){
      list($usec, $sec) = explode(" ", microtime());
      $millisecond = round($usec*1000);
      $millisecond = str_pad($millisecond,3,'0',STR_PAD_RIGHT);
      return strval(date("YmdHis").$millisecond);
   }
}
