<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Оформление заказа");
$APPLICATION->SetTitle("Оформление заказа");
?>

    <section class="text-content">
        <div class="container-fluid text-center">
            <h4 class="mb-4">Заказ №<?=intval($_GET['ORDER_ID'])?> успешно оформлен!</h4>
            <p class="text-secondary mb-5">В ближайшее время с вами свяжется наш менеджер<br/>для уточнения деталей заказа.</p>
            <a href="/personal/" class="btn btn-sm btn-outline-primary py-2 px-4 text-uppercase">
                Перейти в личный кабинет
            </a>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>