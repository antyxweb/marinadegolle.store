<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");


$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
global $USER;

$PRODUCT_ID = $request->get('PRODUCT_ID');

if(intval($PRODUCT_ID) && CModule::IncludeModule("sale")) {
    if (CSaleBasket::Delete($PRODUCT_ID)) {
        echo true;
    }
}