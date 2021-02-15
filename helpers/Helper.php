<?php
/**
 * Created by PhpStorm.
 * User: DAVID01
 * Date: 20/09/2020
 * Time: 10:26
 */


/*
 * Tratamiento de urls
 */

function url_origin( $s, $use_forwarded_host = false )
{
    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
    $port     = $s['SERVER_PORT'];
    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;

    return $protocol . '://' . $host;
}

# $absolute_url = full_url( $_SERVER );
function full_url( $s, $use_forwarded_host = false )
{
    return url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
}

function full_url_without_parameters(){
    $url = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'] . explode('?', $_SERVER['REQUEST_URI'], 2)[0];
    return $url;
}

function look_for_something_in_url($param){
    $absolute_url = full_url( $_SERVER );
    $found_it = strpos($absolute_url,$param);
    //echo "posicion: ".$found_it."del parametro: ".$param."<br>";
    $found_it ? $found_it = true : $found_it = false;
    return $found_it;
}

function url_semantica($string,$keyReplace="-",$minuscula=true){
    $string    =  RemoveSign($string);
    //neu muon de co dau
    //$string     =  trim(preg_replace("/[^A-Za-z0-9àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴÈÉẸẺẼÊỀẾỆỂỄÌÍỊỈĨÒÓỌỎÕÔỒỐỘỔỖƠ$
    $string     =   trim(preg_replace("/[^A-Za-z0-9]/i"," ",$string)); // khong dau
    $string     =    str_replace(" ","-",$string);
    $string     =    str_replace("--","-",$string);
    $string     =    str_replace("--","-",$string);
    $string     =    str_replace("--","-",$string);
    $string     =    str_replace($keyReplace,"-",$string);
    $string     =    ($minuscula) ? strtolower($string) : $string;
    return $string;
}


/**
 * @param $field
 * @return mixed|string|string[]|null
 */
function clean_to_utf8($field){
    $str = utf8_decode($field);
    $str = str_replace("&nbsp;", " ", $str);
    $str = preg_replace('/\s+/', ' ',$str);
    $str = trim($str);

    return $str;
}// end function

/**
 * @param $str
 * @return string
 */
function clean_space($str){
    $str = ltrim(trim(rtrim($str)));
    return $str;
}// end function

function RemoveSign($str){
    $coDau = array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
        "ằ","ắ","ặ","ẳ","ẵ",
        "è","é","ẹ","ẻ","ẽ","ê","ề" ,"ế","ệ","ể","ễ",
        "ì","í","ị","ỉ","ĩ",
        "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
    ,"ờ","ớ","ợ","ở","ỡ",
        "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
        "ỳ","ý","ỵ","ỷ","ỹ",
        "đ",
        "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
    ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
        "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
        "Ì","Í","Ị","Ỉ","Ĩ",
        "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
    ,"Ờ","Ớ","Ợ","Ở","Ỡ",
        "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
        "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
        "Đ","ê","ù","à",
        "Ñ","ñ"
    );

    $khongDau = array("a","a","a","a","a","a","a","a","a","a","a"
    ,"a","a","a","a","a","a",
        "e","e","e","e","e","e","e","e","e","e","e",
        "i","i","i","i","i",
        "o","o","o","o","o","o","o","o","o","o","o","o"
    ,"o","o","o","o","o",
        "u","u","u","u","u","u","u","u","u","u","u",
        "y","y","y","y","y",
        "d",
        "A","A","A","A","A","A","A","A","A","A","A","A"
    ,"A","A","A","A","A",
        "E","E","E","E","E","E","E","E","E","E","E",
        "I","I","I","I","I",
        "O","O","O","O","O","O","O","O","O","O","O","O"
    ,"O","O","O","O","O",
        "U","U","U","U","U","U","U","U","U","U","U",
        "Y","Y","Y","Y","Y",
        "D","e","u","a",
        "N","n"
    );

    return str_replace($coDau,$khongDau,$str);

}// end function


function convert_mayus_accent_to_minus_acent($string){

    $minus = array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
        "ằ","ắ","ặ","ẳ","ẵ",
        "è","é","ẹ","ẻ","ẽ","ê","ề" ,"ế","ệ","ể","ễ",
        "ì","í","ị","ỉ","ĩ",
        "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
    ,"ờ","ớ","ợ","ở","ỡ",
        "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
        "ỳ","ý","ỵ","ỷ","ỹ",
        "đ");

    $mayus = array(
        "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
    ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
        "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
        "Ì","Í","Ị","Ỉ","Ĩ",
        "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
    ,"Ờ","Ớ","Ợ","Ở","Ỡ",
        "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
        "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
        "Đ"
    );

    $fix = str_replace($mayus, $minus, $string);

    return $fix;

}// end function


/**
 * @param $str
 * @return mixed
 */
function replaceAccents($str)
{
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');

    return str_replace($a, $b, $str);
}


function normalizeChars($s)
{
    $replace = array(
        'ъ' => '-', 'Ь' => '-', 'Ъ' => '-', 'ь' => '-',
        'Ă' => 'A', 'Ą' => 'A', 'À' => 'A', 'Ã' => 'A', 'Á' => 'A', 'Æ' => 'A', 'Â' => 'A', 'Å' => 'A', 'Ä' => 'Ae',
        'Þ' => 'B',
        'Ć' => 'C', 'ץ' => 'C', 'Ç' => 'C',
        'È' => 'E', 'Ę' => 'E', 'É' => 'E', 'Ë' => 'E', 'Ê' => 'E',
        'Ğ' => 'G',
        'İ' => 'I', 'Ï' => 'I', 'Î' => 'I', 'Í' => 'I', 'Ì' => 'I',
        'Ł' => 'L',
        'Ñ' => 'N', 'Ń' => 'N',
        'Ø' => 'O', 'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'Oe',
        'Ş' => 'S', 'Ś' => 'S', 'Ș' => 'S', 'Š' => 'S',
        'Ț' => 'T',
        'Ù' => 'U', 'Û' => 'U', 'Ú' => 'U', 'Ü' => 'Ue',
        'Ý' => 'Y',
        'Ź' => 'Z', 'Ž' => 'Z', 'Ż' => 'Z',
        'â' => 'a', 'ǎ' => 'a', 'ą' => 'a', 'á' => 'a', 'ă' => 'a', 'ã' => 'a', 'Ǎ' => 'a', 'а' => 'a', 'А' => 'a', 'å' => 'a', 'à' => 'a', 'א' => 'a', 'Ǻ' => 'a', 'Ā' => 'a', 'ǻ' => 'a', 'ā' => 'a', 'ä' => 'ae', 'æ' => 'ae', 'Ǽ' => 'ae', 'ǽ' => 'ae',
        'б' => 'b', 'ב' => 'b', 'Б' => 'b', 'þ' => 'b',
        'ĉ' => 'c', 'Ĉ' => 'c', 'Ċ' => 'c', 'ć' => 'c', 'ç' => 'c', 'ц' => 'c', 'צ' => 'c', 'ċ' => 'c', 'Ц' => 'c', 'Č' => 'c', 'č' => 'c', 'Ч' => 'ch', 'ч' => 'ch',
        'ד' => 'd', 'ď' => 'd', 'Đ' => 'd', 'Ď' => 'd', 'đ' => 'd', 'д' => 'd', 'Д' => 'D', 'ð' => 'd',
        'є' => 'e', 'ע' => 'e', 'е' => 'e', 'Е' => 'e', 'Ə' => 'e', 'ę' => 'e', 'ĕ' => 'e', 'ē' => 'e', 'Ē' => 'e', 'Ė' => 'e', 'ė' => 'e', 'ě' => 'e', 'Ě' => 'e', 'Є' => 'e', 'Ĕ' => 'e', 'ê' => 'e', 'ə' => 'e', 'è' => 'e', 'ë' => 'e', 'é' => 'e',
        'ф' => 'f', 'ƒ' => 'f', 'Ф' => 'f',
        'ġ' => 'g', 'Ģ' => 'g', 'Ġ' => 'g', 'Ĝ' => 'g', 'Г' => 'g', 'г' => 'g', 'ĝ' => 'g', 'ğ' => 'g', 'ג' => 'g', 'Ґ' => 'g', 'ґ' => 'g', 'ģ' => 'g',
        'ח' => 'h', 'ħ' => 'h', 'Х' => 'h', 'Ħ' => 'h', 'Ĥ' => 'h', 'ĥ' => 'h', 'х' => 'h', 'ה' => 'h',
        'î' => 'i', 'ï' => 'i', 'í' => 'i', 'ì' => 'i', 'į' => 'i', 'ĭ' => 'i', 'ı' => 'i', 'Ĭ' => 'i', 'И' => 'i', 'ĩ' => 'i', 'ǐ' => 'i', 'Ĩ' => 'i', 'Ǐ' => 'i', 'и' => 'i', 'Į' => 'i', 'י' => 'i', 'Ї' => 'i', 'Ī' => 'i', 'І' => 'i', 'ї' => 'i', 'і' => 'i', 'ī' => 'i', 'ĳ' => 'ij', 'Ĳ' => 'ij',
        'й' => 'j', 'Й' => 'j', 'Ĵ' => 'j', 'ĵ' => 'j', 'я' => 'ja', 'Я' => 'ja', 'Э' => 'je', 'э' => 'je', 'ё' => 'jo', 'Ё' => 'jo', 'ю' => 'ju', 'Ю' => 'ju',
        'ĸ' => 'k', 'כ' => 'k', 'Ķ' => 'k', 'К' => 'k', 'к' => 'k', 'ķ' => 'k', 'ך' => 'k',
        'Ŀ' => 'l', 'ŀ' => 'l', 'Л' => 'l', 'ł' => 'l', 'ļ' => 'l', 'ĺ' => 'l', 'Ĺ' => 'l', 'Ļ' => 'l', 'л' => 'l', 'Ľ' => 'l', 'ľ' => 'l', 'ל' => 'l',
        'מ' => 'm', 'М' => 'm', 'ם' => 'm', 'м' => 'm',
        'ñ' => 'n', 'н' => 'n', 'Ņ' => 'n', 'ן' => 'n', 'ŋ' => 'n', 'נ' => 'n', 'Н' => 'n', 'ń' => 'n', 'Ŋ' => 'n', 'ņ' => 'n', 'ŉ' => 'n', 'Ň' => 'n', 'ň' => 'n',
        'о' => 'o', 'О' => 'o', 'ő' => 'o', 'õ' => 'o', 'ô' => 'o', 'Ő' => 'o', 'ŏ' => 'o', 'Ŏ' => 'o', 'Ō' => 'o', 'ō' => 'o', 'ø' => 'o', 'ǿ' => 'o', 'ǒ' => 'o', 'ò' => 'o', 'Ǿ' => 'o', 'Ǒ' => 'o', 'ơ' => 'o', 'ó' => 'o', 'Ơ' => 'o', 'œ' => 'oe', 'Œ' => 'oe', 'ö' => 'oe',
        'פ' => 'p', 'ף' => 'p', 'п' => 'p', 'П' => 'p',
        'ק' => 'q',
        'ŕ' => 'r', 'ř' => 'r', 'Ř' => 'r', 'ŗ' => 'r', 'Ŗ' => 'r', 'ר' => 'r', 'Ŕ' => 'r', 'Р' => 'r', 'р' => 'r',
        'ș' => 's', 'с' => 's', 'Ŝ' => 's', 'š' => 's', 'ś' => 's', 'ס' => 's', 'ş' => 's', 'С' => 's', 'ŝ' => 's', 'Щ' => 'sch', 'щ' => 'sch', 'ш' => 'sh', 'Ш' => 'sh', 'ß' => 'ss',
        'т' => 't', 'ט' => 't', 'ŧ' => 't', 'ת' => 't', 'ť' => 't', 'ţ' => 't', 'Ţ' => 't', 'Т' => 't', 'ț' => 't', 'Ŧ' => 't', 'Ť' => 't', '™' => 'tm',
        'ū' => 'u', 'у' => 'u', 'Ũ' => 'u', 'ũ' => 'u', 'Ư' => 'u', 'ư' => 'u', 'Ū' => 'u', 'Ǔ' => 'u', 'ų' => 'u', 'Ų' => 'u', 'ŭ' => 'u', 'Ŭ' => 'u', 'Ů' => 'u', 'ů' => 'u', 'ű' => 'u', 'Ű' => 'u', 'Ǖ' => 'u', 'ǔ' => 'u', 'Ǜ' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'У' => 'u', 'ǚ' => 'u', 'ǜ' => 'u', 'Ǚ' => 'u', 'Ǘ' => 'u', 'ǖ' => 'u', 'ǘ' => 'u', 'ü' => 'ue',
        'в' => 'v', 'ו' => 'v', 'В' => 'v',
        'ש' => 'w', 'ŵ' => 'w', 'Ŵ' => 'w',
        'ы' => 'y', 'ŷ' => 'y', 'ý' => 'y', 'ÿ' => 'y', 'Ÿ' => 'y', 'Ŷ' => 'y',
        'Ы' => 'y', 'ž' => 'z', 'З' => 'z', 'з' => 'z', 'ź' => 'z', 'ז' => 'z', 'ż' => 'z', 'ſ' => 'z', 'Ж' => 'zh', 'ж' => 'zh'
    );
    return strtr($s, $replace);

}

/**
 * @param $msg
 * @return mixed
 */
function utf8Fix($msg){
    $accents = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç","Ú","ñ","Ú",'é','Nº','ñ');
    $utf8 = array("Ã¡","Ã ","Ã¢","Ã£","Ã¤","Ã©","Ã¨","Ãª","Ã«","Ã­","Ã¬","Ã®","Ã¯","Ã³","Ã²","Ã´","Ãµ","Ã¶","Ãº","Ã¹","Ã»","Ã¼","Ã§","Ã","Ã€","Ã‚","Ãƒ","Ã„","Ã‰","Ãˆ","ÃŠ","Ã‹","Ã","ÃŒ","ÃŽ","Ã","Ã“","Ã’","Ã”","Ã•","Ã–","Ãš","Ã™","Ã›","Ãœ","Ã‡","Ã","Ã±","Ãº",'Ã©','NÂº','Ã±');
    //echo "contador1: ".count($accents)."<br>";
    //echo "contador2: ".count($utf8)."<br>";
    $fix = str_replace($utf8, $accents, $msg);
    return $fix;
}

/**
 * @param $subject
 * @return string
 */
function replace_spec_char($subject)
{
    $char_map = array(
        "ъ" => "-", "ь" => "-", "Ъ" => "-", "Ь" => "-",
        "А" => "A", "Ă" => "A", "Ǎ" => "A", "Ą" => "A", "À" => "A", "Ã" => "A", "Á" => "A", "Æ" => "A", "Â" => "A", "Å" => "A", "Ǻ" => "A", "Ā" => "A", "א" => "A",
        "Б" => "B", "ב" => "B", "Þ" => "B",
        "Ĉ" => "C", "Ć" => "C", "Ç" => "C", "Ц" => "C", "צ" => "C", "Ċ" => "C", "Č" => "C", "©" => "C", "ץ" => "C",
        "Д" => "D", "Ď" => "D", "Đ" => "D", "ד" => "D", "Ð" => "D",
        "È" => "E", "Ę" => "E", "É" => "E", "Ë" => "E", "Ê" => "E", "Е" => "E", "Ē" => "E", "Ė" => "E", "Ě" => "E", "Ĕ" => "E", "Є" => "E", "Ə" => "E", "ע" => "E",
        "Ф" => "F", "Ƒ" => "F",
        "Ğ" => "G", "Ġ" => "G", "Ģ" => "G", "Ĝ" => "G", "Г" => "G", "ג" => "G", "Ґ" => "G",
        "ח" => "H", "Ħ" => "H", "Х" => "H", "Ĥ" => "H", "ה" => "H",
        "I" => "I", "Ï" => "I", "Î" => "I", "Í" => "I", "Ì" => "I", "Į" => "I", "Ĭ" => "I", "I" => "I", "И" => "I", "Ĩ" => "I", "Ǐ" => "I", "י" => "I", "Ї" => "I", "Ī" => "I", "І" => "I",
        "Й" => "J", "Ĵ" => "J",
        "ĸ" => "K", "כ" => "K", "Ķ" => "K", "К" => "K", "ך" => "K",
        "Ł" => "L", "Ŀ" => "L", "Л" => "L", "Ļ" => "L", "Ĺ" => "L", "Ľ" => "L", "ל" => "L",
        "מ" => "M", "М" => "M", "ם" => "M",
        "Ñ" => "N", "Ń" => "N", "Н" => "N", "Ņ" => "N", "ן" => "N", "Ŋ" => "N", "נ" => "N", "ŉ" => "N", "Ň" => "N",
        "Ø" => "O", "Ó" => "O", "Ò" => "O", "Ô" => "O", "Õ" => "O", "О" => "O", "Ő" => "O", "Ŏ" => "O", "Ō" => "O", "Ǿ" => "O", "Ǒ" => "O", "Ơ" => "O",
        "פ" => "P", "ף" => "P", "П" => "P",
        "ק" => "Q",
        "Ŕ" => "R", "Ř" => "R", "Ŗ" => "R", "ר" => "R", "Р" => "R", "®" => "R",
        "Ş" => "S", "Ś" => "S", "Ș" => "S", "Š" => "S", "С" => "S", "Ŝ" => "S", "ס" => "S",
        "Т" => "T", "Ț" => "T", "ט" => "T", "Ŧ" => "T", "ת" => "T", "Ť" => "T", "Ţ" => "T",
        "Ù" => "U", "Û" => "U", "Ú" => "U", "Ū" => "U", "У" => "U", "Ũ" => "U", "Ư" => "U", "Ǔ" => "U", "Ų" => "U", "Ŭ" => "U", "Ů" => "U", "Ű" => "U", "Ǖ" => "U", "Ǜ" => "U", "Ǚ" => "U", "Ǘ" => "U",
        "В" => "V", "ו" => "V",
        "Ý" => "Y", "Ы" => "Y", "Ŷ" => "Y", "Ÿ" => "Y",
        "Ź" => "Z", "Ž" => "Z", "Ż" => "Z", "З" => "Z", "ז" => "Z",
        "а" => "a", "ă" => "a", "ǎ" => "a", "ą" => "a", "à" => "a", "ã" => "a", "á" => "a", "æ" => "a", "â" => "a", "å" => "a", "ǻ" => "a", "ā" => "a", "א" => "a",
        "б" => "b", "ב" => "b", "þ" => "b",
        "ĉ" => "c", "ć" => "c", "ç" => "c", "ц" => "c", "צ" => "c", "ċ" => "c", "č" => "c", "©" => "c", "ץ" => "c",
        "Ч" => "ch", "ч" => "ch",
        "д" => "d", "ď" => "d", "đ" => "d", "ד" => "d", "ð" => "d",
        "è" => "e", "ę" => "e", "é" => "e", "ë" => "e", "ê" => "e", "е" => "e", "ē" => "e", "ė" => "e", "ě" => "e", "ĕ" => "e", "є" => "e", "ə" => "e", "ע" => "e",
        "ф" => "f", "ƒ" => "f",
        "ğ" => "g", "ġ" => "g", "ģ" => "g", "ĝ" => "g", "г" => "g", "ג" => "g", "ґ" => "g",
        "ח" => "h", "ħ" => "h", "х" => "h", "ĥ" => "h", "ה" => "h",
        "i" => "i", "ï" => "i", "î" => "i", "í" => "i", "ì" => "i", "į" => "i", "ĭ" => "i", "ı" => "i", "и" => "i", "ĩ" => "i", "ǐ" => "i", "י" => "i", "ї" => "i", "ī" => "i", "і" => "i",
        "й" => "j", "Й" => "j", "Ĵ" => "j", "ĵ" => "j",
        "ĸ" => "k", "כ" => "k", "ķ" => "k", "к" => "k", "ך" => "k",
        "ł" => "l", "ŀ" => "l", "л" => "l", "ļ" => "l", "ĺ" => "l", "ľ" => "l", "ל" => "l",
        "מ" => "m", "м" => "m", "ם" => "m",
        "ñ" => "n", "ń" => "n", "н" => "n", "ņ" => "n", "ן" => "n", "ŋ" => "n", "נ" => "n", "ŉ" => "n", "ň" => "n",
        "ø" => "o", "ó" => "o", "ò" => "o", "ô" => "o", "õ" => "o", "о" => "o", "ő" => "o", "ŏ" => "o", "ō" => "o", "ǿ" => "o", "ǒ" => "o", "ơ" => "o",
        "פ" => "p", "ף" => "p", "п" => "p",
        "ק" => "q",
        "ŕ" => "r", "ř" => "r", "ŗ" => "r", "ר" => "r", "р" => "r", "®" => "r",
        "ş" => "s", "ś" => "s", "ș" => "s", "š" => "s", "с" => "s", "ŝ" => "s", "ס" => "s",
        "т" => "t", "ț" => "t", "ט" => "t", "ŧ" => "t", "ת" => "t", "ť" => "t", "ţ" => "t",
        "ù" => "u", "û" => "u", "ú" => "u", "ū" => "u", "у" => "u", "ũ" => "u", "ư" => "u", "ǔ" => "u", "ų" => "u", "ŭ" => "u", "ů" => "u", "ű" => "u", "ǖ" => "u", "ǜ" => "u", "ǚ" => "u", "ǘ" => "u",
        "в" => "v", "ו" => "v",
        "ý" => "y", "ы" => "y", "ŷ" => "y", "ÿ" => "y",
        "ź" => "z", "ž" => "z", "ż" => "z", "з" => "z", "ז" => "z", "ſ" => "z",
        "™" => "tm",
        "@" => "at",
        "Ä" => "ae", "Ǽ" => "ae", "ä" => "ae", "æ" => "ae", "ǽ" => "ae",
        "ĳ" => "ij", "Ĳ" => "ij",
        "я" => "ja", "Я" => "ja",
        "Э" => "je", "э" => "je",
        "ё" => "jo", "Ё" => "jo",
        "ю" => "ju", "Ю" => "ju",
        "œ" => "oe", "Œ" => "oe", "ö" => "oe", "Ö" => "oe",
        "щ" => "sch", "Щ" => "sch",
        "ш" => "sh", "Ш" => "sh",
        "ß" => "ss",
        "Ü" => "ue",
        "Ж" => "zh", "ж" => "zh",
    );
    return strtr($subject, $char_map);
}

if (!function_exists('codepoint_encode')) {
    function codepoint_encode($str) {
        return substr(json_encode($str), 1, -1);
    }
}

if (!function_exists('codepoint_decode')) {
    function codepoint_decode($str) {
        return json_decode(sprintf('"%s"', $str));
    }
}

if (!function_exists('mb_internal_encoding')) {
    function mb_internal_encoding($encoding = NULL) {
        return ($from_encoding === NULL) ? iconv_get_encoding() : iconv_set_encoding($encoding);
    }
}

if (!function_exists('mb_convert_encoding')) {
    function mb_convert_encoding($str, $to_encoding, $from_encoding = NULL) {
        return iconv(($from_encoding === NULL) ? mb_internal_encoding() : $from_encoding, $to_encoding, $str);
    }
}

if (!function_exists('mb_chr')) {
    function mb_chr($ord, $encoding = 'UTF-8') {
        if ($encoding === 'UCS-4BE') {
            return pack("N", $ord);
        } else {
            return mb_convert_encoding(mb_chr($ord, 'UCS-4BE'), $encoding, 'UCS-4BE');
        }
    }
}

if (!function_exists('mb_ord')) {
    function mb_ord($char, $encoding = 'UTF-8') {
        if ($encoding === 'UCS-4BE') {
            list(, $ord) = (strlen($char) === 4) ? @unpack('N', $char) : @unpack('n', $char);
            return $ord;
        } else {
            return mb_ord(mb_convert_encoding($char, 'UCS-4BE', $encoding), 'UCS-4BE');
        }
    }
}

if (!function_exists('mb_htmlentities')) {
    function mb_htmlentities($string, $hex = true, $encoding = 'UTF-8') {
        return preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($match) use ($hex) {
            return sprintf($hex ? '&#x%X;' : '&#%d;', mb_ord($match[0]));
        }, $string);
    }
}

if (!function_exists('mb_html_entity_decode')) {
    function mb_html_entity_decode($string, $flags = null, $encoding = 'UTF-8') {
        return html_entity_decode($string, ($flags === NULL) ? ENT_COMPAT | ENT_HTML401 : $flags, $encoding);
    }
}


/*
echo "\nGet string from numeric DEC value\n";
var_dump(mb_chr(25105));
var_dump(mb_chr(22909));

echo "\nGet string from numeric HEX value\n";
var_dump(mb_chr(0x6211));
var_dump(mb_chr(0x597D));

echo "\nGet numeric value of character as DEC int\n";
var_dump(mb_ord('我'));
var_dump(mb_ord('好'));

echo "\nGet numeric value of character as HEX string\n";
var_dump(dechex(mb_ord('我')));
var_dump(dechex(mb_ord('好')));

echo "\nEncode / decode to DEC based HTML entities\n";
var_dump(mb_htmlentities('我好', false));
var_dump(mb_html_entity_decode('&#25105;&#22909;'));

echo "\nEncode / decode to HEX based HTML entities\n";
var_dump(mb_htmlentities('我好'));
var_dump(mb_html_entity_decode('&#x6211;&#x597D;'));

echo "\nUse JSON encoding / decoding\n";
var_dump(codepoint_encode("我好"));
var_dump(codepoint_decode('\u6211\u597d'));
*/


function quitarAcentos($text)
{
    $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
    $text = strtolower($text);
    $patron = array (
        // Espacios, puntos y comas por guion
        '/[\., ]+/' => '-',

        // Vocales
        '/&agrave;/' => 'a',
        '/&egrave;/' => 'e',
        '/&igrave;/' => 'i',
        '/&ograve;/' => 'o',
        '/&ugrave;/' => 'u',

        '/&aacute;/' => 'a',
        '/&eacute;/' => 'e',
        '/&iacute;/' => 'i',
        '/&oacute;/' => 'o',
        '/&uacute;/' => 'u',

        '/&acirc;/' => 'a',
        '/&ecirc;/' => 'e',
        '/&icirc;/' => 'i',
        '/&ocirc;/' => 'o',
        '/&ucirc;/' => 'u',

        '/&atilde;/' => 'a',
        '/&etilde;/' => 'e',
        '/&itilde;/' => 'i',
        '/&otilde;/' => 'o',
        '/&utilde;/' => 'u',

        '/&auml;/' => 'a',
        '/&euml;/' => 'e',
        '/&iuml;/' => 'i',
        '/&ouml;/' => 'o',
        '/&uuml;/' => 'u',
        '/&auml;/' => 'a',
        '/&euml;/' => 'e',
        '/&iuml;/' => 'i',
        '/&ouml;/' => 'o',
        '/&uuml;/' => 'u',

        // Otras letras y caracteres especiales
        '/&aring;/' => 'a',
        '/&ntilde;/' => 'n',
        // Agregar aqui mas caracteres si es necesario
    );

    $text = preg_replace(array_keys($patron),array_values($patron),$text);
    return $text;
}




function limpiar_archivo($name)
{
    if(stristr($name, '.jpg'))
    {
        //quitamos la extension al archivo
        $nombre = str_replace('.jpg', '', $name);
        //limpiamos el nombre
        $nombre = url_semantica($nombre);
        //añadimos la extension al archivo
        $nombre = $nombre.'.jpg';
    }
    elseif(stristr($name, '.jpeg'))
    {
        //quitamos la extension al archivo
        $nombre = str_replace('.jpeg', '', $name);
        //limpiamos el nombre
        $nombre = url_semantica($nombre);
        //añadimos la extension al archivo
        $nombre = $nombre.'.jpeg';
    }
    elseif(stristr($name, '.gif'))
    {
        //quitamos la extension al archivo
        $nombre = str_replace('.gif', '', $name);
        //limpiamos el nombre
        $nombre = url_semantica($nombre);
        //añadimos la extension al archivo
        $nombre = $nombre.'.gif';
    }
    elseif(stristr($name, '.png'))
    {
        //quitamos la extension al archivo
        $nombre = str_replace('.png', '', $name);
        //limpiamos el nombre
        $nombre = url_semantica($nombre);
        //añadimos la extension al archivo
        $nombre = $nombre.'.png';
    }
    elseif(stristr($name, '.pdf'))
    {
        //quitamos la extension al archivo
        $nombre = str_replace('.pdf', '', $name);
        //limpiamos el nombre
        $nombre = url_semantica($nombre);
        //añadimos la extension al archivo
        $nombre = $nombre.'.pdf';
    }

    return $nombre;
}

function indexar_array($array,$index){
    if(!is_array($array)) return array($array->$index => $array);
    $return_array = array();
    foreach($array as $data){
        if(is_object($data))
            $return_array[$data->$index] = $data;
        else
            $return_array[$data[$index]]=$data;
    }
    return $return_array;
}

function p2bd($fecha){
    list($iDia,$iMes,$iAnyo)=explode("/",$fecha);
    return date("Y-m-d",mktime(0,0,0,$iMes,$iDia,$iAnyo));
}

function bd2p($fecha){
    list($iAnyo,$iMes,$iDia)=explode("-",$fecha);
    return date("d/m/Y",mktime(0,0,0,$iMes,$iDia,$iAnyo));
}

function interval($fecha_ini,$fecha_fin){
    $datetime1 = new DateTime($fecha_ini);
    $datetime2 = new DateTime($fecha_fin);
    $interval = $datetime1->diff($datetime2);
    $num_dias = $interval->days;
    return $num_dias;
}

function p_() {

    $args       = func_get_args();
    $num_args   = func_num_args();
    $label = "";

    $font_size = '14';
    $box_size = '10';
    $has_todo = false;
    $bg_color_div = 'white';
    $show_div = true;

    if($num_args>0){
        $last_arg = func_get_arg($num_args-1);
        echo "<div><pre>";
        echo "<div style='margin: 10px; margin-top: 70px; border:0px; padding: 2px;'>";
        $background_color = 'green';
        if(is_string($last_arg) && ($last_arg!="") && substr($last_arg,0,6)==='__lab:'){
            $label = substr($last_arg, 6, strlen($last_arg));
            unset($args[$num_args-1]);
            $label_error = strtolower($label);
            $background_color = '#FF8000';
            if($label_error == 'error' || $label_error == 'exception'){
                $label = 'Exception';
                $background_color = '#C42732';
            }
            if($label_error == 'dev_info'){
                $label = 'Development info';
                $background_color = '#C42732';
                $font_size = '12';
                $box_size = '5';
            }
            if($label_error == 'todo'){
                $label = '!!!!!!!!!! Todo !!!!!!!!!!';
                $background_color = '#f442b0';
                $bg_color_div = '';
                $font_size = '12';
                $box_size = '5';
                $has_todo = true;
            }
            if($label_error == 'empty'){
                $show_div=false;
            }
        }else{
            $label = "PRINT";
        }

        $file_info_used = print_debug('1', false, true);

        // if(is_string($last_arg) && ($last_arg!="") && substr($last_arg,0,4)==='__^:'){
        // 	$key_begins_with = substr($last_arg, 3, strlen($last_arg));
        // 	unset($args[$num_args-1]);
        // 	$label = "BEGINS WITH";
        // }
        if($show_div){
            echo "<div style='margin:10px; margin-bottom:10px;'>".
                "<span style=\"background-color: $background_color; color: white; font-size: 12px; padding: ".$box_size ."px; border: 2px solid black;\"><b>"
                . $label . "</b></span></div>";
        }

        $count = 1;

        foreach($args as $arg){
            if($show_div){
                echo "<div style='margin: 10px 10px 2px 10px; border:2px solid black; padding: 5px; background-color: $bg_color_div;'>";
            }
            if(count($args)>1){
                echo "<span style='font-size: 12px; font-weight: bold; color: red; padding:2px;'>Variable: ".$count."</span></br>";
            }
            if(is_string($arg)){
                if(is_null($arg) || $arg == 'null'){
                    echo "<span style='color:red; font-weight: bold; font-size:".$font_size."px;'>".$arg."</span>";
                }else{
                    echo "<span style='color:green; font-weight: bold; font-size: ".$font_size."px;'>".$arg."</span>";
                }
            }else{
                print_r($arg);
            }
            if($show_div){
                echo "</div>";
            }
            // echo "<div style=\"height:10px;\"></div>";
            ++$count;
        }
        echo "<div style='font-style:italic; padding-left: 10px; font-size: 10px; text-align:right; margin:0px; padding: 0px;'>$file_info_used</div></div>";
        echo "</pre></div>";
        // echo "<br/>";
    }
    return;
}

function print_debug($step_back=2, $fb=false, $file_info_only=false){

    $debug = debug_backtrace();
    $function = $debug[$step_back]['function'];
    $line = isset($debug[$step_back]['line']) ? $debug[$step_back]['line'] : -1;
    $args = isset($debug[$step_back]['args']) ? $debug[$step_back]['args'] : -1;
    $file = isset($debug[$step_back]['file']) ? $debug[$step_back]['file'] : -1;
    if($file_info_only){
        return $file.' => LINE:'.$line;
    }

    if($fb==false){
        d_('called function:'.$function);
        d_('called line:'.$line);
        d_('called arguments:'.$args);
        d_('called file:'.$file);
    }else{
        fb_('called function:'.$function);
        fb_('called line:'.$line);
        fb_('called arguments:'.$args);
        fb_('called file:'.$file);
    }
}

?>