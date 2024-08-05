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