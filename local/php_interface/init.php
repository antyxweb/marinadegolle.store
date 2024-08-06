<?php
use Bitrix\Sale;
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

require_once 'vendor/autoload.php';

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
function print_p($val, $name = '', $mode = false, $die = false){
    global $USER;
    if($USER->IsAdmin()){
        echo '<pre>'.(!empty($name) ? $name.': ' : ''); if($mode) { var_dump($val); } else { print_r($val); } echo '</pre>';
        if($die) die;
    }
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function AddOrderProperty($prop_id, $value, $order) {
    if (!strlen($prop_id)) {
        return false;
    }
    if (CModule::IncludeModule('sale')) {
        if ($arOrderProps = CSaleOrderProps::GetByID($prop_id)) {
            $db_vals = CSaleOrderPropsValue::GetList(array(), array('ORDER_ID' => $order, 'ORDER_PROPS_ID' => $arOrderProps['ID']));
            if ($arVals = $db_vals->Fetch()) {
                return CSaleOrderPropsValue::Update($arVals['ID'], array(
                    'NAME' => $arVals['NAME'],
                    'CODE' => $arVals['CODE'],
                    'ORDER_PROPS_ID' => $arVals['ORDER_PROPS_ID'],
                    'ORDER_ID' => $arVals['ORDER_ID'],
                    'VALUE' => $value,
                ));
            } else {
                return CSaleOrderPropsValue::Add(array(
                    'NAME' => $arOrderProps['NAME'],
                    'CODE' => $arOrderProps['CODE'],
                    'ORDER_PROPS_ID' => $arOrderProps['ID'],
                    'ORDER_ID' => $order,
                    'VALUE' => $value,
                ));
            }
        }
    }
}

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/loggg.txt");
define("YOOKASSA_LOGIN", '371968');
define("YOOKASSA_PASSWORD", 'live_B-gSiBT9GqLbtP5dnLcF6-ugf5q92YJFl7SJ08lc_o0');

//AddEventHandler("sale", "OnStatusUpdate", Array("MyClass", "StatusUpdate"));
//
//class MyClass
//{
//    function StatusUpdate($ID, $val){
//        AddMessage2Log($ID."вызывается после изменения статуса заказа OnStatusUpdate: ".$val);
//    }
//}

AddEventHandler("sale", 'OnSaleStatusOrder', 'changeStatus');
function changeStatus($ORDER_ID, $status) {

    if($status == 'W') {
        $order = Sale\Order::load($ORDER_ID);

        $client = new \YooKassa\Client();
        $client->setAuth(YOOKASSA_LOGIN, YOOKASSA_PASSWORD);

        try {
            $idempotenceKey = uniqid('', true);
            $response = $client->createPayment(
                [
                    'amount' => [
                        'value' => $order->getPrice(),
                        'currency' => 'RUB',
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'locale' => 'ru_RU',
                        'return_url' => 'https://marinadegolle.store/payment/?ORDER_ID='.$ORDER_ID,
                    ],
                    'capture' => true,
                    'description' => 'Заказ №'.$ORDER_ID,
                    'metadata' => [
                        'orderNumber' => $ORDER_ID
                    ],
                ],
                $idempotenceKey
            );

            //получаем confirmationUrl для дальнейшего редиректа
            $id = $response->getId();
            AddOrderProperty(7, $id, $ORDER_ID);
            $confirmationUrl = $response->getConfirmation()->getConfirmationUrl();
            AddOrderProperty(8, $confirmationUrl, $ORDER_ID);
        } catch (\Exception $e) {
            $response = $e;
        }

//        if (!empty($response)) {
//            print_r($response);
//        }
//        AddMessage2Log($ORDER_ID." - ".$status);
    }
}