<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Личный кабинет");
$APPLICATION->SetTitle("Личный кабинет");
?>

    <section id="cart">
        <div class="row">
            <?if(!$USER->IsAuthorized()):?>
                <div class="col-12 col-lg-6 col-xl-3 mx-auto">
                    <form class="personal-form">
                        <input type="text" name="TYPE" value="AUTH" hidden>

                        <h4 class="mb-4 text-center">Пожалуйста, авторизуйтесь</h4>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="EMAIL" placeholder="E-mail *" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" name="PASSWORD" placeholder="Пароль *" required>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary p-3 d-block text-uppercase w-100">Войти</button>

                        <div class="personal-error my-4" style="color: red"></div>

                        <div class="row">
                            <div class="col-6">
                                <a href="/personal/register/">Регистрация</a>
                            </div>
                            <div class="col-6 text-right">
                                <a href="/personal/forgot/">Забыли пароль</a>
                            </div>
                        </div>
                    </form>
                </div>
            <?else:?>
                <div class="col-12 col-md-6 mb-5">
                    <h3 class="mb-4">Заказы</h3>

                    <?
                    CModule::IncludeModule('sale');

                    $orders = \Bitrix\Sale\Order::loadByFilter(array(
                        'filter' => [
                            'USER_ID' => $USER->GetID(),
                            'LID' => 's1',
                        ],
                        'select' => ['ID'],
                        'order' => ['ID' => 'DESC'],
                    ));

                    if($orders)
                    {
                        foreach($orders as $order)
                        {
                            $orderVal = $order->getFields()->getValues();

                            $status = '';
                            $border = '';
                            $paymentButton = '';

                            if($orderVal['CANCELED'] == 'Y') {
                                $status = ' <span class="badge badge-secondary ml-2">Отменен</span>';
                            } else {

                                if($orderVal['PAYED'] == 'Y') {
                                    $status .= ' <span class="badge badge-success ml-2">Оплачен</span>';
                                } else {
                                    $status .= ' <span class="badge badge-danger ml-2">Не оплачен</span>';
                                }

                                if($orderVal['STATUS_ID'] == 'N') {
                                    $status .= ' <span class="badge badge-warning ml-2">Ожидает подтверждения</span>';
                                    $border = 'border-warning';
                                } else if($orderVal['STATUS_ID'] == 'W') {
                                    $status .= ' <span class="badge badge-warning ml-2">Ожидает оплаты</span>';
                                    $border = 'border-warning';
                                } else if($orderVal['STATUS_ID'] == 'D') {
                                    $status .= ' <span class="badge badge-warning ml-2">В доставке</span>';
                                    $border = 'border-warning';
                                } else if($orderVal['STATUS_ID'] == 'F') {
                                    $status = ' <span class="badge badge-success ml-2">Выполнен</span>';
                                    $border = 'border-success';
                                }

                                if($orderVal['PAYED'] == 'N' && $orderVal['STATUS_ID'] == 'W') {
                                    $propertyCollection = $order->getPropertyCollection();
                                    $orderPaymentId = $propertyCollection->getItemByOrderPropertyId(7)->getValue();
                                    $orderPaymentUrl = $propertyCollection->getItemByOrderPropertyId(8)->getValue();
                                    $paymentButton .= '<a href="'.$orderPaymentUrl.'" class="btn btn-secondary p-3 d-block text-uppercase">Оплатить заказ</a>';

                                    //Проверка оплаты
                                    $client = new \YooKassa\Client();
                                    $client->setAuth(YOOKASSA_LOGIN, YOOKASSA_PASSWORD);

                                    try {
                                        $response = $client->getPaymentInfo($orderPaymentId);
                                    } catch (\Exception $e) {
                                        $response = $e;
                                    }

                                    $paymentStatus = $response->getStatus();
                                    if($paymentStatus == 'succeeded') {
                                        $status = ' <span class="badge badge-warning ml-2">В доставке</span> <span class="badge badge-success ml-2">Оплачен</span>';
                                        $border = 'border-warning';
                                        $paymentButton = '';

                                        $paymentCollection = $order->getPaymentCollection();
                                        if(!$paymentCollection->isPaid()) {
                                            $onePayment = $paymentCollection[0];
                                            $onePayment->setPaid("Y");
                                            $order->setField('STATUS_ID', 'D');
                                            $order->save();
                                        }
                                    }
                                }
                            }

                            ?>
                            <div class="border <?=$border?> p-4 mb-4">
                                <div class="d-flex">
                                    <h5 class="mr-auto">Заказ #<b><?=$orderVal['ID']?></b> от <?=$orderVal['DATE_INSERT']?></h5>

                                    <div class="order-status mb-3">
                                        <?
                                        echo $status;
                                        ?>
                                    </div>
                                </div>
                                <h6 class="mb-4">Сумма заказа: <b><?=number_format($orderVal['PRICE'], 0, ',', ' ')?></b> РУБ.</h6>
                                <h6>Состав заказа:</h6>
                                <table>
                                    <?
                                    $res = CSaleBasket::GetList(array(), array("ORDER_ID" => $orderVal['ID']));

                                    while ($arItem = $res->Fetch()) {
                                        $res2 = CIBlockElement::GetByID($arItem['ID']);
                                        if($ar_res = $res2->GetNext()) {
                                            if($ar_res['PREVIEW_PICTURE']) {
                                                $src = CFile::GetPath($ar_res['PREVIEW_PICTURE']);
                                            } else {
                                                $src = '';
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td class="py-3">
                                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="d-block product-img" target="_blank">
                                                    <div class="embed-responsive embed-responsive-1by1" style="background-image: url('<?=$src?>');width: 100px;"></div>
                                                </a>
                                            </td>
                                            <td class="py-3 pl-3 pl-md-4">
                                                <p><?=$arItem['NAME']?></p>
                                                <div class="price"><?=$arItem['PRICE']?number_format($arItem['PRICE'], 0, ',', ' ').' РУБ.':''?></div>
                                            </td>
                                            <td class="py-3 pl-3 pl-md-4">
                                                <?=$arItem['QUANTITY']?>&nbsp;шт.
                                            </td>
                                            <td class="py-3 pl-3 pl-md-4">
                                                <div class="price"><?=number_format($arItem['PRICE']*$arItem['QUANTITY'], 0, ',', '&nbsp;')?>&nbsp;РУБ.</div>
                                            </td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                </table>
                                <?=$paymentButton?>
                            </div>
                            <?
                        }
                    } else {
                        ?>
                        <p>У вас пока нет заказов</p>

                        <a href="/catalog/" class="btn btn-sm btn-outline-primary py-2 px-4 text-uppercase">
                            Перейти в каталог
                        </a>
                        <?
                    }
                    ?>
                </div>
                <div class="col-12 col-md-5 offset-md-1">
                    <form class="personal-form">
                        <input type="text" name="TYPE" value="UPDATE" hidden>

                        <h4 class="mb-4">Ваши данные</h4>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="NAME" value="<?=$USER->GetFirstName()?>" placeholder="Имя *" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="EMAIL" value="<?=$USER->GetEmail()?>" placeholder="E-mail *" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="password" class="form-control" name="NEW_PASSWORD" placeholder="Новый пароль">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="password" class="form-control" name="CONFIRM_NEW_PASSWORD" placeholder="Повторите новый пароль">
                                </div>
                            </div>
                        </div>

                        <div class="personal-error my-4" style="color: red"></div>

                        <div class="row align-items-center">
                            <div class="col-6">
                                <button class="btn btn-primary p-3 d-block text-uppercase w-100">Сохранить</button>
                            </div>
                            <div class="col-6 text-right">
                                <a href="/personal/?logout=yes&<?=bitrix_sessid_get()?>" class="btn btn-sm btn-outline-primary py-2 px-4 text-uppercase">
                                    Выйти
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            <?endif;?>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>