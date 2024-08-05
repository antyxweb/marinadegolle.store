<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$templateLibrary = array('popup', 'fx', 'ui.fonts.opensans');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$haveOffers = !empty($arResult['OFFERS']);

$templateData = [
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => [
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
	],
];
if ($haveOffers)
{
	$templateData['ITEM']['OFFERS_SELECTED'] = $arResult['OFFERS_SELECTED'];
	$templateData['ITEM']['JS_OFFERS'] = $arResult['JS_OFFERS'];
}
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DESCRIPTION_ID' => $mainId.'_description',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

if ($haveOffers)
{
	$actualItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] ?? reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['MORE_PHOTO_COUNT'] > 1)
		{
			$showSliderControls = true;
			break;
		}
	}
}
else
{
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y')
{
	$skuDescription = false;
	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['DETAIL_TEXT'] != '' || $offer['PREVIEW_TEXT'] != '')
		{
			$skuDescription = true;
			break;
		}
	}
	$showDescription = $skuDescription || !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}
else
{
	$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);
$productType = $arResult['PRODUCT']['TYPE'];

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');

if ($arResult['MODULES']['catalog'] && $arResult['PRODUCT']['TYPE'] === ProductTable::TYPE_SERVICE)
{
	$arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE_SERVICE']
		?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE_SERVICE')
	;
	$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE_SERVICE']
		?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE_SERVICE')
	;
}
else
{
	$arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE']
		?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE')
	;
	$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE']
		?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE')
	;
}

$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$sections = [];

$list = CIBlockSection::GetNavChain(false,$actualItem['IBLOCK_SECTION_ID'], array(), true);
foreach ($list as $arSectionPath){
    $sections[] = $arSectionPath['NAME'];
}

?>

<pre><?//print_r($actualItem);?></pre>

    <section id="product" itemscope itemtype="http://schema.org/Product">
        <div class="row">
            <div class="product-slider col-12 col-md-6 pb-5">
                <ul id="vertical">
                    <?
                    foreach ($actualItem['PROPERTIES']['MORE_PHOTOS']['VALUE'] as $key => $photoId)
                    {
                        $photo = CFile::GetPath($photoId);
                        ?>
                        <li data-thumb="<?=$photo?>">
                            <div class="embed-responsive embed-responsive-1by1" style="background-image: url('<?=$photo?>')"></div>
                            <img class="d-none" src="<?=$photo?>" <?=($key == 0 ? ' itemprop="image"' : '')?>>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="col-12 col-md-6">
                <div class="product-info">
                    <h1 class="mb-md-4"><?=$name?></h1>
                    <div class="price mb-md-4"><?=$price['RATIO_PRICE']?$price['PRINT_RATIO_PRICE']:'Цена по запросу'?></div>
                    <div class="description d-none d-md-block">
                        <?=$actualItem['PREVIEW_TEXT']?>
                    </div>

                    <div class="product-action d-flex my-3 py-3 my-md-4 py-md-5">
                        <div class="product-counter d-none d-lg-flex mr-4">
                            <button class="minus">&mdash;</button>
                            <input type="text" value="1">
                            <button class="plus">+</button>
                        </div>
                        <button class="to-cart btn btn-primary p-3 d-block text-uppercase" data-id="<?=$actualItem['ID']?>">Добавить в корзину</button>
                        <button class="to-favorites d-none d-lg-block ml-4">
                            <svg width="19" height="17" viewBox="0 0 19 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_38_148)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.38755 2.73291C1.77787 3.5289 1.44694 4.63511 1.44694 5.80381C1.44694 6.99805 1.91622 8.19873 2.68333 9.35819C3.4491 10.5157 4.48342 11.5887 5.54029 12.5121C6.59435 13.4331 7.65188 14.1887 8.4476 14.7148C8.84473 14.9773 9.17481 15.1815 9.4044 15.3194C9.40422 15.3193 9.40468 15.3195 9.4044 15.3194C9.4046 15.3193 9.40546 15.3195 9.40575 15.3194C9.63533 15.1815 9.96544 14.9773 10.3626 14.7148C11.1583 14.1887 12.2158 13.4331 13.2699 12.5121C14.3267 11.5887 15.361 10.5157 16.1269 9.35819C16.8939 8.19873 17.3632 6.99805 17.3632 5.80381C17.3632 4.63381 17.0347 3.52772 16.4267 2.73233C15.8344 1.95743 14.9582 1.44694 13.7459 1.44694C12.5137 1.44694 11.5867 1.95732 10.9534 2.48504C10.6364 2.74925 10.3984 3.01375 10.2413 3.21017C10.1631 3.30799 10.1058 3.38776 10.0696 3.44055C10.0515 3.4669 10.0387 3.48641 10.0314 3.49793C10.0277 3.50369 10.0253 3.50743 10.0244 3.50904C10.0239 3.50985 10.0242 3.50933 10.0244 3.50904L9.40768 4.53691L8.78762 3.51203C8.78782 3.51232 8.78811 3.51284 8.78762 3.51203C8.78704 3.51111 8.78551 3.50872 8.78416 3.50648C8.78301 3.50472 8.78166 3.50256 8.78002 3.5C8.77247 3.48843 8.75966 3.46885 8.74141 3.44243C8.70485 3.38951 8.64707 3.30957 8.56828 3.2116C8.41006 3.01487 8.17084 2.75002 7.85282 2.48551C7.21712 1.95688 6.28998 1.44694 5.06428 1.44694C3.85867 1.44694 2.98194 1.95687 2.38755 2.73291ZM9.40509 16.1575L9.7561 16.79L9.40509 16.9848L9.05405 16.79L9.40509 16.1575ZM1.23884 1.85308C2.09441 0.736028 3.38805 0 5.06428 0C6.72039 0 7.96365 0.695832 8.77797 1.37299C9.02327 1.57698 9.23173 1.78085 9.40365 1.96657C9.57485 1.78093 9.78264 1.57725 10.0272 1.37346C10.8408 0.695397 12.0842 0 13.7459 0C15.4274 0 16.7217 0.735478 17.5763 1.85366C18.4152 2.95133 18.8102 4.3854 18.8102 5.80381C18.8102 7.37802 18.1943 8.85573 17.3335 10.1566C16.4715 11.4595 15.3355 12.6288 14.2219 13.6018C13.1056 14.5771 11.9927 15.3717 11.1606 15.9218C10.7438 16.1974 10.3958 16.4127 10.1505 16.5599C10.0279 16.6336 9.9309 16.6902 9.86376 16.7289C9.8302 16.7482 9.80406 16.763 9.78592 16.7733C9.77685 16.7785 9.7698 16.7824 9.76479 16.7852C9.76229 16.7866 9.76036 16.7877 9.75892 16.7885L9.7561 16.79C9.75593 16.7902 9.7561 16.79 9.40509 16.1575C9.05405 16.79 9.05425 16.7902 9.05405 16.79L9.05126 16.7885C9.04982 16.7877 9.04789 16.7866 9.04538 16.7852C9.04034 16.7824 9.03332 16.7785 9.02425 16.7733C9.00612 16.763 8.97998 16.7482 8.94641 16.7289C8.87928 16.6902 8.78232 16.6336 8.65963 16.5599C8.41441 16.4127 8.06636 16.1974 7.64957 15.9218C6.81749 15.3717 5.70458 14.5771 4.58827 13.6018C3.4747 12.6288 2.33864 11.4595 1.47661 10.1566C0.615923 8.85573 0 7.37802 0 5.80381C0 4.38411 0.398562 2.95015 1.23884 1.85308Z" fill="#1D1D1D"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_38_148">
                                        <rect width="19" height="16.9848" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </button>
                    </div>

                    <div class="description d-md-none">
                        <?=$actualItem['PREVIEW_TEXT']?>
                    </div>

                    <ul class="params">
                        <li>
                            <span>Артикул:</span> <?=$actualItem['PROPERTIES']['SKU']['VALUE']?>
                        </li>
                        <li>
                            <span>Категория:</span> <?=implode(' - ', $sections);?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="my-4 py-md-5">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#description">Описание</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#characteristics">Дополнительная информация</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="description">
                    <?=$actualItem['DETAIL_TEXT']?>
                </div>
                <div class="tab-pane fade" id="characteristics">
                    <ul class="params">
                        <?
                        foreach ($actualItem['PROPERTIES']['PROPS']['VALUE'] as $key => $val)
                        {
                            ?>
                            <li>
                                <span><?=$actualItem['PROPERTIES']['PROPS']['DESCRIPTION'][$key]?>:</span> <?=$val?>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <h3 class="section-title">Смотрите также:</h3>
    </section>

<?php
unset($actualItem, $itemIds, $jsParams);
