<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var string $discountPositionClass
 * @var string $labelPositionClass
 * @var CatalogSectionComponent $component
 */
?>

<div class="embed-responsive embed-responsive-1by1" style="background-image: url('<?=$item['PREVIEW_PICTURE']['SRC']?>')"></div>
<h3><?=$item['NAME']?></h3>
<div class="price"><?if($price['RATIO_BASE_PRICE']):?><?=$price['PRINT_RATIO_BASE_PRICE']?><?else:?>Цена по запросу<?endif;?></div>
<a href="<?=$item['DETAIL_PAGE_URL']?>" class="stretched-link"></a>