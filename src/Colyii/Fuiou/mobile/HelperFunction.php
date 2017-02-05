<?php
/**
 * @Author: Coly Cao
 * @Date:   2017-02-04 16:25:28
 * @Last Modified by:   Coly Cao
 * @Last Modified time: 2017-02-04 17:15:57
 */
namespace Colyii\Fuiou\mobile;

class HelperFunction
{
    //调外部接口，拼接 HTML
    public static function buildForm($arr_parameter, $url)
    {
        $sHtml = "<form id='payform' name='payform' accept-charset='utf-8' onsubmit=\"document.charset='utf-8';\" action='" . $url . "' method='post', target=''>";

        while (list($key, $val) = each($arr_parameter)) {
            $sHtml .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml . "<input type='submit' value='确认付款' style='display: none;'></form>";
        $sHtml = $sHtml . "<script>document.forms['payform'].submit();</script>";

        return $sHtml;
    }

    //生成唯一不重复订单号
    public static function buildOn()
    {
        return date('Ymd') . substr(implode(null, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 12);
    }

    public static function unset_keys($data)
    {
        ksort($data);
        $unset_keys = array(
            'url',
            'signature',
            'resp_desc',
            'artif_nm',
        );
        if (in_array($data['url'], array('changeMobile', 'authConfig', 'changeCard2'))) {
            $unset_keys = array(
                'url',
                'signature',
                'artif_nm',
            );
        }

        foreach ($unset_keys as $key => $value) {
            if (array_key_exists($value, $data)) {
                unset($data[$value]);
            }
        }
        return implode('|', $data);
    }

    /**
     * [xml_object xml转对象]
     * @param  [xml] $xml [待处理的xml数据]
     * @return [object]      [返回对象]
     */
    public static function xml_object($xml)
    {
        $string = simplexml_load_string($xml);
        $json   = json_encode($string);
        $object = json_decode($json);
        return $object;
    }
}
