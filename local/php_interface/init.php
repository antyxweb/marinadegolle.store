<?php
CModule::IncludeModule("iblock");

$arSelect = Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_VALUES");
$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arProps = $ob->GetProperties();

    $GLOBALS['SETTINGS'][$arFields['CODE']] = [
        'NAME' => $arFields['NAME'],
        'VALUES' => $arProps['VALUES']['VALUE']
    ];
}

/**
 * обёртка для print_r() и var_dump()
 * @param $val - значение
 * @param string $name - заголовок
 * @param bool $mode - использовать var_dump() или print_r()
 * @param bool $die - использовать die() после вывода
 */
function print_p($val, $name = 'Содержимое переменной', $mode = false, $die = false){
    global $USER;
    if($USER->IsAdmin()){
        echo '<pre>'.(!empty($name) ? $name.': ' : ''); if($mode) { var_dump($val); } else { print_r($val); } echo '</pre>';
        if($die) die;
    }
}