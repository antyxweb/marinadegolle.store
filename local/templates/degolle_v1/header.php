<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<!DOCTYPE html>
<html lang="ru" class="h-100">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <link rel="apple-touch-icon" sizes="180x180" href="/www/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/www/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/www/favicon-16x16.png">
        <link rel="shortcut icon" href="/www/favicon.ico" type="image/x-icon" />
        <link rel="manifest" href="/www/site.webmanifest">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <?$APPLICATION->ShowHead();?>
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH;?>/css/styles.min.css?v<?=time();?>" />

        <title><?$APPLICATION->ShowTitle();?></title>
    </head>
    <body class="d-flex flex-column section-<?=str_replace('/', '-', $GLOBALS["APPLICATION"]->GetCurPage(false))?>">
        <?$APPLICATION->ShowPanel();?>
        
        <header id="header">
            <div class="d-flex">
                <a href="/" class="shield flex-center">
                    <svg width="26" height="30" viewBox="0 0 26 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.729 11.8061V8.99594L12.7527 3.21608L2.77437 8.99594V20.5596L12.7527 26.3395L22.729 20.5596V16.171H21.2506V13.3845H25.5034V22.1677L12.7527 29.5556L0 22.1677V7.38791L12.7527 0L25.5034 7.38791V11.8061H22.729ZM18.9887 19.8857V11.3962L20.4691 10.5389L17.8636 9.02945L12.7586 11.9854L7.65358 9.02945L5.03432 10.5409L6.50888 11.3962V19.8817L9.09476 21.3814V12.8958L12.7527 15.0123L16.4008 12.8978V21.3833L18.9887 19.8857Z" fill="black"/>
                    </svg>
                </a>
                <a href="javascript:void(0);" class="menu flex-center" data-dropdown-toggle="menu">
                    <svg width="19" height="12" viewBox="0 0 19 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line y1="1" x2="19" y2="1" stroke="#B1B1B1" stroke-width="2"/>
                        <line y1="6" x2="19" y2="6" stroke="#B1B1B1" stroke-width="2"/>
                        <line y1="11" x2="19" y2="11" stroke="#B1B1B1" stroke-width="2"/>
                    </svg>
                </a>

                <a href="/" class="logo flex-center">
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/logo.svg" alt="">
                </a>

                <?$APPLICATION->IncludeComponent(
                    "bitrix:sale.basket.basket.line",
                    "header",
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
                        "SHOW_EMPTY_VALUES" => "Y",
                        "SHOW_NUM_PRODUCTS" => "Y",
                        "SHOW_PERSONAL_LINK" => "N",
                        "SHOW_PRODUCTS" => "N",
                        "SHOW_REGISTRATION" => "N",
                        "SHOW_TOTAL_PRICE" => "N"
                    )
                );?>
                <!--a href="/search/" class="search flex-center">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.391 20.2635L15.969 14.9283C17.3889 13.3857 18.2613 11.3456 18.2613 9.10073C18.2606 4.29846 14.305 0.406006 9.42522 0.406006C4.54541 0.406006 0.589844 4.29846 0.589844 9.10073C0.589844 13.903 4.54541 17.7955 9.42522 17.7955C11.5336 17.7955 13.4674 17.0662 14.9864 15.8538L20.4294 21.2101C20.6946 21.4713 21.1252 21.4713 21.3904 21.2101C21.6562 20.9488 21.6562 20.5248 21.391 20.2635ZM9.42522 16.4577C5.29637 16.4577 1.94929 13.1639 1.94929 9.10073C1.94929 5.03757 5.29637 1.74374 9.42522 1.74374C13.5541 1.74374 16.9011 5.03757 16.9011 9.10073C16.9011 13.1639 13.5541 16.4577 9.42522 16.4577Z" fill="black"/>
                    </svg>
                </a-->
                <a href="/personal/" class="search flex-center">
                    <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><title/><g id="about"><path d="M16,16A7,7,0,1,0,9,9,7,7,0,0,0,16,16ZM16,4a5,5,0,1,1-5,5A5,5,0,0,1,16,4Z"/><path d="M17,18H15A11,11,0,0,0,4,29a1,1,0,0,0,1,1H27a1,1,0,0,0,1-1A11,11,0,0,0,17,18ZM6.06,28A9,9,0,0,1,15,20h2a9,9,0,0,1,8.94,8Z"/></g></svg>
                </a>
            </div>
        </header>

        <div id="dropdown" class="_is-visible _open-menu">
            <div class="dropdown-close"></div>

            <div class="dropdown-slide left">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "sidebar-menu",
                    Array(
                        "ALLOW_MULTI_SELECT" => "Y",
                        "CHILD_MENU_TYPE" => "left",
                        "COMPONENT_TEMPLATE" => ".default",
                        "DELAY" => "Y",
                        "MAX_LEVEL" => "2",
                        "MENU_CACHE_GET_VARS" => "",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "top",
                        "USE_EXT" => "Y"
                    )
                );?>
            </div>
            <div class="dropdown-slide right">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:sale.basket.basket.line",
                    "dropdown",
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
            </div>
        </div>

        <main id="main" class="flex-shrink-0 mb-auto">
            <?if($GLOBALS["APPLICATION"]->GetCurPage(false) != '/'):?>
                <section id="title">
                    <h1><?$APPLICATION->ShowTitle(false);?></h1>
                </section>
            <?endif;?>
