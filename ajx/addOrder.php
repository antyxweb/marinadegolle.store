<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");

use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order;

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
global $USER;

$error = [];

//Служебные параметры
$siteId = Context::getCurrent()->getSite();
$currencyCode = CurrencyManager::getBaseCurrency();

//Загружаем корзину
$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), $siteId);

$rsUser = CUser::GetByLogin($request['ORDER']['EMAIL']);
$arUser = $rsUser->Fetch();
if($arUser['ID']) {
    $orderUserID = $arUser['ID'];
} else {
    $newPassword = randomPassword();
    $arResult = $USER->Register($request['ORDER']['EMAIL'], $request['ORDER']['NAME'].' '.$request['ORDER']['SURNAME'], "", $newPassword, $newPassword, $request['ORDER']['EMAIL']);
    $orderUserID = $USER->GetID();

    CEvent::Send(
        "NEW_USER",
        's1',
        array(
            "R_EMAIL" => $request['ORDER']['EMAIL'],
            "R_NAME" => $request['ORDER']['NAME'],
            "R_PASSWORD" => 'Ваш пароль для входа: '.$newPassword,
        ),
        '',
        52
    );
}

// Создаёт новый заказ
$order = Order::create($siteId, $orderUserID);
$order->setPersonTypeId(1);
$order->setField('CURRENCY', $currencyCode);


//Информация о пользователе
$propertyCollection = $order->getPropertyCollection();

$propertyCodeToId = array();
foreach($propertyCollection as $propertyValue) {
    $propertyCodeToId[$propertyValue->getField('CODE')] = $propertyValue->getField('ORDER_PROPS_ID');
}

foreach ($request['ORDER'] as $key => $field) {
    $propertyValue=$propertyCollection->getItemByOrderPropertyId($propertyCodeToId[$key]);
    $propertyValue->setValue($field);
}

/*if ($DATA['COMMENTS']) {
    $order->setField('USER_DESCRIPTION', $DATA['COMMENTS']);
}*/

//Проверяем доступность товаров
$availableBasket = $basket->getOrderableItems();
$order->setBasket($availableBasket);

//Способ доставки

$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem(
    Bitrix\Sale\Delivery\Services\Manager::getObjectById(2)
);
$shipmentItemCollection = $shipment->getShipmentItemCollection();

//if(isset($DATA['DELIVERY_PRICE'])) {
//    $service = Bitrix\Sale\Delivery\Services\Manager::getById(2);
//    $deliveryData = [
//        'DELIVERY_ID' => $service['ID'],
//        'DELIVERY_NAME' => $service['NAME'],
//        'ALLOW_DELIVERY' => 'Y',
//        'PRICE_DELIVERY' => 0,
//        'CUSTOM_PRICE_DELIVERY' => 'Y'
//    ];
//    $shipment->setFields($deliveryData);
//}

$shipmentItemCollection = $shipment->getShipmentItemCollection();

foreach ($basket as $basketItem)
{
    $item = $shipmentItemCollection->createItem($basketItem);
    $item->setQuantity($basketItem->getQuantity());
}

//Способ оплаты

$paymentCollection = $order->getPaymentCollection();
$payment = $paymentCollection->createItem(
    Bitrix\Sale\PaySystem\Manager::getObjectById(2)
);

$payment->setField("SUM", $order->getPrice());
$payment->setField("CURRENCY", $order->getCurrency());

// Сохраняем
$order->doFinalAction(true);
$result = $order->save();

if (!$result->isSuccess())
{
    echo json_encode([
        'SUCCESS' => false,
        'MESSAGE' => $result->getErrorMessages(),
    ]);
} else {
    //Выводим ID заказа
    $orderId = $order->getId();

    send_whatsapp("Новый заказ #".$orderId." от ".$request['ORDER']['NAME']." ".$request['ORDER']['PHONE']);

    echo json_encode([
        'SUCCESS' => true,
        'ORDER_ID' => $orderId,
    ]);
}