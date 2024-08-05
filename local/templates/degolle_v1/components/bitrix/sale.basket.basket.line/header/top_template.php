<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
?>

<a href="<?= $arParams['PATH_TO_BASKET'] ?>" class="cart flex-center" data-dropdown-toggle="cart" title="<?=$arResult['PRODUCTS']?>">
    <svg width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.5143 0H5.4857V6.92309H0V27H24V6.92309H18.5143V0ZM16.4571 8.99999V13.5H18.5143V8.99999H21.9429V24.9231H2.05714V8.99999H5.4857V13.5H7.54286V8.99999H16.4571ZM16.4571 6.92309V2.07692H7.54286V6.92309H16.4571Z" fill="#1D1D1D"/>
    </svg>
    <small class="cnt"><?=$arResult['NUM_PRODUCTS']?></small>
</a>