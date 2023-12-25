<?php 
namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class FDateComponent extends Component
{
    public    function div($a, $b)
    {
        return (int)($a / $b);
    }
    public function diffDate($dateMain){
        $dateNow    =    date('Y-m-d H:i:s');
        $interval    =    date_diff(date_create($dateMain),date_create($dateNow));
        $result = "";
        if ($interval->y) { 
                    if($interval->format("%y") == 1){$result .="پارسال"." ";}
                    elseif($interval->format("%y") == 2){$result .="پیارسال"." ";}
                    else{    $result .= Yii::$app->fstring->translateDigits($interval->format("%y"))." "."سال"." ".' '.'پیش';  }         
        }
        else{
            if ($interval->m) { $result .= Yii::$app->fstring->translateDigits($interval->format("%m"))." "."ماه"." ".' '.'پیش'; }
            else{
                if ($interval->d) { 
                    if($interval->format("%d") == 1){$result .="دیروز"." ";}
                    elseif($interval->format("%d") == 2){$result .="پریروز"." ";}
                    else{    $result .= Yii::$app->fstring->translateDigits($interval->format("%d"))." "."روز"." ".' '.'پیش';  } 
                    
                }else{
                    if ($interval->h) { $result .= Yii::$app->fstring->translateDigits($interval->format("%h"))." "."ساعت"." ".' '.'پیش'; }
                    else{
                        if ($interval->i) { $result .= Yii::$app->fstring->translateDigits($interval->format("%i"))." "."دقیقه"." ".' '.'پیش'; }
                        else{
                            if ($interval->s) { $result .= Yii::$app->fstring->translateDigits($interval->format("%s"))." "."ثانیه"." ".' '.'پیش'; }
                        }
                    }
                }
            }
        }

        return $result;
     
    }
    public function jalali_to_gergorian_string($dateJalali, $separateJalali = '/', $separateGergorian = '-')
    {
        if (empty($dateJalali)) {
            return date("Y{$separateGergorian}m{$separateGergorian}d");
        }
        $arrString         = explode($separateJalali, $dateJalali);
        // $temp            = explode('', $arrString[2]);
        // $arrString[2]    =    $temp[0];
        $arrString     = $this->jalali_to_gregorian($arrString[0], $arrString[1], $arrString[2]);
        if ($arrString[2] < 10) {
            $arrString[2] = '0' . $arrString[2];
        }
        if ($arrString[1] < 10) {
            $arrString[1] = '0' . $arrString[1];
        }

        $dateGergorian = implode($separateGergorian, $arrString);

        return $dateGergorian;
    }
    public function jalali_to_gregorian($j_y, $j_m, $j_d)
    {
        $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

        $jy = $j_y - 979;
        $jm = $j_m - 1;
        $jd = $j_d - 1;

        $j_day_no = 365 * $jy + $this->div($jy, 33) * 8 + $this->div($jy % 33 + 3, 4);
        for ($i = 0; $i < $jm; ++$i) {
            $j_day_no += $j_days_in_month[$i];
        }

        $j_day_no += $jd;

        $g_day_no = $j_day_no + 79;

        $gy       = 1600 + 400 * $this->div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
        $g_day_no = $g_day_no % 146097;

        $leap = TRUE;
        if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */ {
            $g_day_no--;
            $gy += 100 * $this->div($g_day_no, 36524); /* 36524 = 365*100 + 100/4 - 100/100 */
            $g_day_no = $g_day_no % 36524;

            if ($g_day_no >= 365) {
                $g_day_no++;
            } else {
                $leap = FALSE;
            }
        }

        $gy += 4 * $this->div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
        $g_day_no %= 1461;

        if ($g_day_no >= 366) {
            $leap = FALSE;

            $g_day_no--;
            $gy += $this->div($g_day_no, 365);
            $g_day_no = $g_day_no % 365;
        }

        for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++) {
            $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
        }
        $gm = $i + 1;
        $gd = $g_day_no + 1;

        return array($gy, $gm, $gd);
    }
    public function gergorian_to_jalali_string($dateGergorian, $separateGergorian = '-', $separateJalali = '/')
    {
        if ($dateGergorian != 0) {
            $dateGergorian  = explode(' ' , $dateGergorian);
            
            $arrString  = explode($separateGergorian, $dateGergorian[0]);

            $arrString[0]   =   is_numeric($arrString[0])?$arrString[0]:0;
            $arrString[1]   =   is_numeric($arrString[1])?$arrString[1]:0;
            $arrString[2]   =   is_numeric($arrString[2])?$arrString[2]:0;

            
            $arrString  = $this->gregorian_to_jalali($arrString[0], $arrString[1], $arrString[2]);
            
            if ($arrString[2] < 10) {
                $arrString[2] = '0' . $arrString[2];
            } 
            if ($arrString[1] < 10) {
                $arrString[1] = '0' . $arrString[1];
            } 
            
            $dateJalali = implode($separateJalali, $arrString);
            return $dateJalali;
        } else {
            return '--';
        }
    }
    public   function gregorian_to_jalali($g_y, $g_m, $g_d)
    {
        $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

        $gy = $g_y - 1600;
        $gm = $g_m - 1;
        $gd = $g_d - 1;

        $g_day_no = 365 * $gy + $this->div($gy + 3, 4) - $this->div($gy + 99, 100) + $this->div($gy + 399, 400);

        for ($i = 0; $i < $gm; ++$i) {
            $g_day_no += $g_days_in_month[$i];
        }
        if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0))) /* leap and after Feb */ {
            $g_day_no++;
        }
        $g_day_no += $gd;

        $j_day_no = $g_day_no - 79;

        $j_np     = $this->div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
        $j_day_no = $j_day_no % 12053;

        $jy = 979 + 33 * $j_np + 4 * $this->div($j_day_no, 1461); /* 1461 = 365*4 + 4/4 */

        $j_day_no %= 1461;

        if ($j_day_no >= 366) {
            $jy += $this->div($j_day_no - 1, 365);
            $j_day_no = ($j_day_no - 1) % 365;
        }

        for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i) {
            $j_day_no -= $j_days_in_month[$i];
        }
        $jm = $i + 1;
        $jd = $j_day_no + 1;

        return array($jy, $jm, $jd);
    }

    public  function convertDateToJalali($gregorianDate,$outputSepretor = '-')
    {
        if(strpos($gregorianDate,'-') !== false)
        {
            $date = explode('-',$gregorianDate);
        }
        else if(strpos($gregorianDate,'/') !== false)
        {
            $date = explode('/',$gregorianDate);
        }
        else die('فرمت تاریخ معتبر نیست!');

        $arrDate = yii::$app->jdate->toJalaliDate($date[0],$date[1],$date[2]);
        return $output = implode($outputSepretor,$arrDate);
    }    

    public  function convertDateToGregorian($jalaliDate,$outputSepretor = '-')
    {
        if(strpos($jalaliDate,'-') !== false)
        {   
            $date = explode('-',$jalaliDate);
        }
        else if(strpos($jalaliDate,'/') !== false)
        {    
            $date = explode('/',$jalaliDate);
        }
        else die('فرمت تاریخ معتبر نیست!');

        $arrDate = yii::$app->jdate->toGregorian($date[0],$date[1],$date[2]);
        return $output = implode($outputSepretor,$arrDate);
    }
    
    public function getToday($output='-')
    {
        $date = date('Y-m-d');
        return $this->convertDateToJalali($date,$output);
    }
    
    public function getDayName($date)
    {
        $unixTimestamp = strtotime($date);
        $dayOfWeek = date("l", $unixTimestamp);
        return  yii::$app->jdate->getDayName($dayOfWeek);
    }

    public function getDayNumberOfWeek($persianDate)
    {
        $dayOfWeek = date('w', strtotime($this->convertDateToGregorian($persianDate,'-')));
        switch ($dayOfWeek){
            case 6:
                return 1;
            case 0:
                return 2;
            case 1:
                return 3;
            case 2:
                return 4;
            case 3:
                return 5;
            case 4:
                return 6;
            case 5:
                return 7;
        }
    }

    public function calculateAge($birthday,$toDate = false)
    {
        if(!$toDate)
            $toDate = date('Y-m-d');
        $date1 = date_create("$birthday");
        $date2 = date_create("$toDate");
        $interval = date_diff($date1, $date2);
        return  array('year' => $interval->y,'month' => $interval->m , 'day' => $interval->d);
    }
    
    public function checkDateGreaterThanToday($date)
    {
        $today = date('Y-m-d');

        if ($today > $date) 
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function getCustomDateByDayCount($dayCount,$fromDate = false,$type = '+')
    {
        if(!$fromDate)
           $fromDate = date('Y-m-d'); 
           
        $datetime = new \DateTime($fromDate);
        $datetime->modify($type . $dayCount .' day');
        return $datetime->format('Y-m-d');
    }
    
    public function checkDateIsBetweenDate($date,$startDate,$endDate)
    {
        
        $date               = new \DateTime($date);
        $contractDateBegin  = new \DateTime($startDate);
        $contractDateEnd    = new \DateTime($endDate);

        if (($date >= $contractDateBegin) && ($date <= $contractDateEnd))
             return true;
        else return false;
    }
    
    public function checkDateIsGreaterThanDate($date,$endDate)
    {
        $date               = new \DateTime($date);
        $contractDateEnd    = new \DateTime($endDate);

        if ($date >= $contractDateEnd)
             return true;
        else return false;
    }
    
    public function getYear()
    {
        $date = $this->getToday();
        return Utility::explodText($date,0,'-');
    }
    
    public function getMounth()
    {
        $date = $this->getToday();
        return Utility::explodText($date,1,'-');
    }
    
    public function getDay()
    {
        $date = $this->getToday();
        return Utility::explodText($date,2,'-');
    }

}
?>