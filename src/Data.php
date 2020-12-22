<?php
namespace Pctco\File;
/**
 * 数据
 */
class Data{
   /**
   * @name week
   * @describe 周/星期
   * @return Array
   **/
   public static function week(){
      return [
         [
            'US'   =>   'Sunday',
            'US-abridge'   =>   'Sun',
            'CN'   =>   '星期日',
            'CN-abridge'   =>   '周日'
         ],[
            'US'   =>   'baiMonday',
            'US-abridge'   =>   'baiMon',
            'CN'   =>   '星期一',
            'CN-abridge'   =>   '周一'
         ],[
            'US'   =>   'Tuesday',
            'US-abridge'   =>   'Tues',
            'CN'   =>   '星期二',
            'CN-abridge'   =>   '周二'
         ],[
            'US'   =>   'Wednesday',
            'US-abridge'   =>   'Wed',
            'CN'   =>   '星期三',
            'CN-abridge'   =>   '周三'
         ],[
            'US'   =>   'Thursday',
            'US-abridge'   =>   'Thur',
            'CN'   =>   '星期四',
            'CN-abridge'   =>   '周四'
         ],[
            'US'   =>   'Friday',
            'US-abridge'   =>   'Fri',
            'CN'   =>   '星期五',
            'CN-abridge'   =>   '周五'
         ],[
            'US'   =>   'Saturday',
            'US-abridge'   =>   'Sat',
            'CN'   =>   '星期六',
            'CN-abridge'   =>   '周六'
         ]
      ];
   }
   /**
   * @name zodiac
   * @describe 生肖
   * @return Array
   **/
   public static function zodiac(){
      return [
         [
            'US'   =>   'Rat',
            'CN'   =>   '鼠'
         ],[
            'US'   =>   'OX',
            'CN'   =>   '牛'
         ],[
            'US'   =>   'Tiger',
            'CN'   =>   '虎'
         ],[
            'US'   =>   'Rabbit',
            'CN'   =>   '兔'
         ],[
            'US'   =>   'Dragon',
            'CN'   =>   '龙'
         ],[
            'US'   =>   'Snake',
            'CN'   =>   '蛇'
         ],[
            'US'   =>   'Horse',
            'CN'   =>   '马'
         ],[
            'US'   =>   'Sheep',
            'CN'   =>   '羊'
         ],[
            'US'   =>   'Monkey',
            'CN'   =>   '猴'
         ],[
            'US'   =>   'Rooster',
            'CN'   =>   '鸡'
         ],[
            'US'   =>   'Dog',
            'CN'   =>   '狗'
         ],[
            'US'   =>   'Pig',
            'CN'   =>   '猪'
         ]
      ];
   }
   /**
   * @name constellation
   * @describe 星座
   * @author
   * @param mixed
   * @return
   **/
   public static function constellation(){
      return [
         [
            'US'   =>   'Aries',
            'CN'   =>   '白羊座'
         ],[
            'US'   =>   '金牛座',
            'CN'   =>   'Taurus'
         ],[
            'US'   =>   'Gemini',
            'CN'   =>   '双子座'
         ],[
            'US'   =>   'Cancer',
            'CN'   =>   '巨蟹座'
         ],[
            'US'   =>   'Leo',
            'CN'   =>   '狮子座'
         ],[
            'US'   =>   'Virgo',
            'CN'   =>   '处女座'
         ],[
            'US'   =>   'Libra',
            'CN'   =>   '天秤座'
         ],[
            'US'   =>   'Scorpio',
            'CN'   =>   '天蝎座'
         ],[
            'US'   =>   'Sagittarius',
            'CN'   =>   '射手座'
         ],[
            'US'   =>   'Capricorn',
            'CN'   =>   '摩羯座'
         ],[
            'US'   =>   'Aquarius',
            'CN'   =>   '水瓶座'
         ],[
            'US'   =>   'Pisces',
            'CN'   =>   '双鱼座'
         ]
      ];
   }
}
