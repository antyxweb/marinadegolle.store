<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$this->IncludeLangFile('template.php');

$cartId = $arParams['cartId'];

require(realpath(__DIR__).'/top_template.php');

use Bitrix\Main\Grid\Declension;
$productDeclension = new Declension('товар', 'товара', 'товаров');

$ar_country = GetCountryArray();
?>

<section id="cart">
    <div class="row">
        <?if($arResult["CATEGORIES"]['READY']):?>
            <div class="col-12 col-md-6">
                <table>
                    <?foreach ($arResult["CATEGORIES"] as $category => $items):
                        if (empty($items) || $category != 'READY')
                            continue;
                        ?>
                        <?foreach ($items as $v):?>
                            <tr>
                                <td>
                                    <a href="<?=$v["DETAIL_PAGE_URL"]?>" class="d-block product-img">
                                        <div class="embed-responsive embed-responsive-1by1" style="background-image: url('<?=$v["PICTURE_SRC"]?>')"></div>
                                    </a>
                                </td>
                                <td class="w-100 pl-4 pl-md-5">
                                    <h6><?=$v["NAME"]?></h6>
                                    <div class="price"><?if($v["PRICE"]):?><?=$v["PRICE_FMT"]?><?else:?>Цена по запросу<?endif;?></div>
                                </td>
                                <td class="px-4 px-md-5">
                                    <div class="product-counter d-flex">
                                        <button class="minus">&mdash;</button>
                                        <input type="text" value="<?=$v["QUANTITY"]?>" data-id="<?=$v["ID"]?>" readonly>
                                        <button class="plus">+</button>
                                    </div>
                                </td>
                                <td>
                                    <div class="product-remove" data-id="<?=$v["ID"]?>">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1.18344L12.8166 13M1 12.8166L12.8166 1" stroke="black" stroke-width="1.5"/>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                        <?endforeach?>
                    <?endforeach?>
                </table>
            </div>
            <div class="col-12 col-md-6">
                <form class="order-form">
                    <h3 class="mb-4">Заказ:</h3>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="ORDER[NAME]" placeholder="Имя *" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="ORDER[SURNAME]" placeholder="Фамилия *" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="ORDER[PHONE]" placeholder="Телефон *" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="email" class="form-control" name="ORDER[EMAIL]" placeholder="E-mail *" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <select class="custom-select" name="ORDER[COUNTRY]" required>
                                    <option>Страна *</option>
                                    <?foreach ($ar_country['reference'] as $country):?>
                                        <option value="<?=$country?>"><?=$country?></option>
                                    <?endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="ORDER[ADDRESS]" placeholder="Адрес *" required>
                            </div>
                        </div>
                    </div>
                    <p class="text-secondary">После добавления товара в корзину и нажатие на кнопку “Заказать”, с вами свяжется менеджер для уточнения цены</p>

                    <div class="d-flex my-4 my-md-5">
                        <div class="cart-total-amount text-uppercase">Итого</div>
                        <div class="cart-total-price ml-auto text-uppercase"><?=$arResult['TOTAL_PRICE']?></div>
                    </div>

                    <button class="btn btn-primary p-3 d-block text-uppercase w-100">Заказать</button>

                    <div class="order-error mt-4" style="color: red"></div>
                </form>
            </div>
        <?else:?>
            <div class="col-12 text-center">
                <p class="text-center mb-5">Ваша корзина пуста</p>

                <a href="/catalog/women/" class="btn btn-sm btn-outline-primary py-2 px-4 text-uppercase">Перейти в каталог</a>
            </div>
        <?endif;?>
    </div>
</section>

<script>
    BX.ready(function(){
        <?=$cartId?>.fixCart();
    });
</script>