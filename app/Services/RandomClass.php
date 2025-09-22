<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RandomClass
{
    private static function yearStr(): string
    {
        $year = date('y');
        return match ($year) {
            '20' => 'AA',
            '21' => 'AB',
            '22' => 'AC',
            '23' => 'AD',
            '24' => 'AE',
            '25' => 'AF',
            '26' => 'AG',
            '28' => 'AH',
            '29' => 'AJ',
            '30' => 'AK',
            '31' => 'AL',
            '32' => 'AM',
            '33' => 'AN',
            '34' => 'AP',
            '35' => 'AR',
            '36' => 'AT',
            '37' => 'AU',
            '38' => 'AW',
            '39' => 'AX',
            '40' => 'AY',
            '41' => 'AZ',
            '42' => 'BA',
            '43' => 'BB',
            '44' => 'BC',
            '45' => 'BD',
            '46' => 'BE',
            '47' => 'BF',
            '48' => 'BG',
            '49' => 'BH',
            '50' => 'BJ',

            default => 'XX',
        };

    }

    private static function monthStr(): string
    {
        $month = date('n');
        return match ($month) {
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => 'C',
            '11' => 'N',
            '12' => 'D',
            default => 'XX',
        };

    }

    private static function dateStr(): string
    {
        $strData = '123456789ABCDEFGHJKLMNPRSTUWXYZ';
        $date = date('j');
        return match ($date) {
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => 'A',
            '11' => 'B',
            '12' => 'C',
            '13' => 'D',
            '14' => 'E',
            '15' => 'F',
            '16' => 'G',
            '17' => 'H',
            '18' => 'J',
            '19' => 'K',
            '20' => 'L',
            '21' => 'M',
            '22' => 'N',
            '23' => 'P',
            '24' => 'R',
            '25' => 'S',
            '26' => 'T',
            '27' => 'U',
            '28' => 'W',
            '29' => 'X',
            '30' => 'Y',
            '31' => 'Z',
            default => 'XX',
        };
    }

    private static function randStr($len = 10): string
    {
        return substr(str_shuffle("ABCDEFGHJKLMNPRSTWXYZ23456789"),0,$len);
    }





    private static function randStrOnly($len = 10): string
    {
        return substr(str_shuffle("ABCDEFGHJKLMNPRSTWXYZ"),0,$len);
    }



    public static function randomYMDS($num=10): string
    {
        $y = date('y');
        $m= self::monthStr();
        $d = self::dateStr();
        $s = self::randStr($num);

        return $y.$m.$d.$s;
    }


    public static function randomYMS($num=10): string
    {
        $y = date('y');
        $m= self::monthStr();
        $s = self::randStr($num);
        return $y.$m.$s;
    }

    public static function randomYMDS_2tab($num=10): string
    {
        $a = self::randomYMDS($num);
        $b = self::randStr($num+4);
        return $a.'-'.$b;
    }

    public static function randomYMDS_3tab($num=10): string
    {
        $a = self::randomYMDS($num);
        $b = self::randStr($num);
        $c = self::randStr($num+4);
        return $a.'-'.$b.'-'.$c;
    }

    public static function randomYMDS_4tab($num=10): string
    {
        $a = self::randomYMDS($num);
        $b = self::randStr($num);
        $c = self::randStr($num);
        $d = self::randStr($num+4);
        return $a.'-'.$b.'-'.$c.'-'.$d;
    }


    public static function randomYMDS_5tab($num=10): string
    {
        $a = self::randomYMDS($num);
        $b = self::randStr($num);
        $c = self::randStr($num);
        $d = self::randStr($num);
        $e = self::randStr($num+4);
        return $a.'-'.$b.'-'.$c.'-'.$d.'-'.$e;
    }

    public static function randomStr($num=10): string
    {
        return self::randStr($num);
    }

    public static function randomStrOnly($num=10): string
    {
        return self::randStrOnly($num);
    }

    public static function randomChkTblStrOnly($table,$field_name,$num=10,$str1=null,$str2=null): string
    {
        $rdm = $str1.$str2.self::randStrOnly($num);
        $coba = array();
        while (DB::table($table)->where($field_name,$rdm)->count() > 0) {
            $rdm = $str1.$str2.self::randStrOnly($num);
            array_push($coba,$rdm);

            if(count($coba)>100)
            {
                return 'Pecobaan maximum telah tercapai, coba lagi besok';
            }
        };
        return $rdm;
    }
    public static function randomChkTblYMDS($table,$field_name,$num=10,$str1=null,$str2=null): string
    {
        $string_1 = $str1;
        $string_2 = $str2;
        $rdm = $string_1.$string_2.self::randomYMDS($num);
        $coba = array();
        while (DB::table($table)->where($field_name,$rdm)->count() > 0) {
            $rdm = $string_1.$string_2.self::randomYMDS($num);
            array_push($coba,$rdm);

            if(count($coba)>100)
            {
                return 'Pecobaan maximum telah tercapai, coba lagi besok';
            }
        };
        return $rdm;
    }

    public static function randomChkTblYMS($table,$field_name,$num=10,$str1=null,$str2=null): string
    {
        $string_1 = $str1;
        $string_2 = $str2;
        $rdm = $string_1.$string_2.self::randomYMS($num);
        $coba = array();
        while (DB::table($table)->where($field_name,$rdm)->count() > 0) {
            $rdm = $string_1.$string_2.self::randomYMS($num);
            array_push($coba,$rdm);

            if(count($coba)>100)
            {
                return 'Pecobaan maximum telah tercapai, coba lagi besok';
            }
        };
        return $rdm;
    }
}
