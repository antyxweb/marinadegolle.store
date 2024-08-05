<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Корзина");
$APPLICATION->SetTitle("Корзина");
?>

    <?$APPLICATION->IncludeComponent(
        "bitrix:sale.basket.basket.line",
        "cart",
        Array(
            "COMPONENT_TEMPLATE" => ".default",
            "HIDE_ON_BASKET_PAGES" => "N",
            "PATH_TO_AUTHORIZE" => "",
            "PATH_TO_BASKET" => SITE_DIR."cart/",
            "PATH_TO_ORDER" => SITE_DIR."cart/order/",
            "PATH_TO_PERSONAL" => SITE_DIR."personal/",
            "PATH_TO_PROFILE" => SITE_DIR."personal/",
            "PATH_TO_REGISTER" => SITE_DIR."login/",
            "POSITION_FIXED" => "N",
            "SHOW_AUTHOR" => "N",
            "SHOW_DELAY" => "N",
            "SHOW_EMPTY_VALUES" => "Y",
            "SHOW_IMAGE" => "Y",
            "SHOW_NOTAVAIL" => "N",
            "SHOW_NUM_PRODUCTS" => "Y",
            "SHOW_PERSONAL_LINK" => "N",
            "SHOW_PRICE" => "Y",
            "SHOW_PRODUCTS" => "Y",
            "SHOW_REGISTRATION" => "N",
            "SHOW_SUMMARY" => "Y",
            "SHOW_TOTAL_PRICE" => "Y"
        )
    );?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>