<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Оплата заказа");
$APPLICATION->SetTitle("Оплата заказа");

if(!intval($_GET['ORDER_ID'])) {
    LocalRedirect('/');
}

use Bitrix\Sale;

$order = Sale\Order::load(intval($_GET['ORDER_ID']));
$propertyCollection = $order->getPropertyCollection();
$orderPaymentId = $propertyCollection->getItemByOrderPropertyId(7)->getValue();
$orderPaymentUrl = $propertyCollection->getItemByOrderPropertyId(8)->getValue();

$client = new \YooKassa\Client();
$client->setAuth(YOOKASSA_LOGIN, YOOKASSA_PASSWORD);

try {
    $response = $client->getPaymentInfo($orderPaymentId);
} catch (\Exception $e) {
    $response = $e;
}

$paymentStatus = $response->getStatus();

if($paymentStatus == 'succeeded') {
    $paymentCollection = $order->getPaymentCollection();

    if(!$paymentCollection->isPaid()) {
        $onePayment = $paymentCollection[0];
        $onePayment->setPaid("Y");
        $order->setField('STATUS_ID', 'D');
        $order->save();
    }

    $successText = 'успешно оплачен';
    $successDescription = 'В ближайшее время с вами свяжется наш менеджер<br/>для уточнения деталей доставки.';
} else {
    $successText = '<span class="text-danger">не оплачен</span>';
    $successDescription = 'При оплате произошла какая-то ошибка.<br/>Попробуйте <a href="'.$orderPaymentUrl.'"><u>оплатить</u></a> еще раз или свяжитесь с менеджером';
}
?>

    <section class="text-content">
        <div class="container-fluid text-center">
            <h4 class="mb-4">Заказ №<?=intval($_GET['ORDER_ID'])?> <?=$successText?>!</h4>
            <p class="text-secondary mb-5"><?=$successDescription?></p>
            <a href="/personal/" class="btn btn-sm btn-outline-primary py-2 px-4 text-uppercase">
                Перейти в личный кабинет
            </a>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>