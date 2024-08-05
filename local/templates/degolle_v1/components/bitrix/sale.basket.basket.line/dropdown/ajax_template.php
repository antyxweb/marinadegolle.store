<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$this->IncludeLangFile('template.php');

$cartId = $arParams['cartId'];

require(realpath(__DIR__).'/top_template.php');

use Bitrix\Main\Grid\Declension;
$productDeclension = new Declension('товар', 'товара', 'товаров');
?>
<div class="cart-list">
    <h3 class="mb-3">Заказ</h3>
    <p><?=$arResult['NUM_PRODUCTS'].' '.$productDeclension->get($arResult['NUM_PRODUCTS']);?></p>

    <div id="<?=$cartId?>products">
        <ul class="cart">
            <?foreach ($arResult["CATEGORIES"] as $category => $items):
                if (empty($items))
                    continue;
                ?>
                <?foreach ($items as $v):?>
                    <li>
                        <div class="d-flex">
                            <a href="<?=$v["DETAIL_PAGE_URL"]?>" class="d-block product-img">
                                <div class="embed-responsive embed-responsive-1by1" style="background-image: url('<?=$v["PICTURE_SRC"]?>')"></div>
                            </a>
                            <div class="product-info">
                                <div class="product-remove" data-id="<?=$v["ID"]?>">
                                    <svg width="8" height="7" viewBox="0 0 8 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.43018 0.818034L6.88196 6.26982M1.43018 6.18519L6.88196 0.733398" stroke="black" stroke-width="1.38411"/>
                                    </svg>
                                </div>
                                <div class="d-flex flex-column pl-3 h-100">
                                    <h6><?=$v["NAME"]?></h6>
                                    <div class="price"><?if($v["PRICE"]):?><?=$v["PRICE_FMT"]?><?else:?>Цена по запросу<?endif;?></div>
                                    <div class="product-counter mt-auto">
                                        <span>Кол-во:</span>
                                        <button class="minus">&mdash;</button>
                                        <input type="text" value="<?=$v["QUANTITY"]?>" data-id="<?=$v["ID"]?>" readonly>
                                        <button class="plus">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?endforeach?>
            <?endforeach?>
        </ul>
    </div>
</div>
<div class="cart-total">
    <div class="d-flex mb-3">
        <div class="cart-total-amount">Итого (<?=$arResult['NUM_PRODUCTS'].' '.$productDeclension->get($arResult['NUM_PRODUCTS']);?>)</div>
        <div class="cart-total-price ml-auto text-uppercase"><?=$arResult['TOTAL_PRICE']?></div>
    </div>

    <a href="/cart/" class="btn btn-outline-primary p-3 d-block text-uppercase">Просмотреть корзину</a>
</div>

<script>
    BX.ready(function(){
        <?=$cartId?>.fixCart();
    });
</script>