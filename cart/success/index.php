<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Оформление заказа");
$APPLICATION->SetTitle("Оформление заказа");
?>

    <section class="text-content">
        <div class="container-fluid text-center">
            <h4 class="mb-4">Заказ №<?=intval($_GET['ORDER_ID'])?> успешно оформлен!</h4>
            <p style="color: #948D88">В ближайшее время с вами свяжется наш менеджер<br/>для уточнения деталей заказа.</p>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>