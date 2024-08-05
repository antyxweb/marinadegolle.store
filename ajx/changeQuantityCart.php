<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");


$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
global $USER;

$PRODUCT_ID = $request->get('PRODUCT_ID');
$QUANTITY = $request->get('QUANTITY');

if(intval($PRODUCT_ID) && intval($QUANTITY) && CModule::IncludeModule("sale")) {
    $arFields = array(
        "QUANTITY" => $QUANTITY,
    );
    if(CSaleBasket::Update($PRODUCT_ID, $arFields)) {
        echo true;
    }
}