<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Восстановление пароля");
$APPLICATION->SetTitle("Восстановление пароля");

global $USER;
if($USER->IsAuthorized()) {
    LocalRedirect('/personal/');
}
?>

    <section id="cart">
        <div class="row">
            <?if(isset($_GET['success']) && $_GET['success'] == 'Y'):?>
                <div class="col-12 text-center">
                    <p class="text-center mb-5">Пароль был выслан на указанную почту</p>

                    <a href="/personal/" class="btn btn-sm btn-outline-primary py-2 px-4 text-uppercase">
                        Войти
                    </a>
                </div>
            <?else:?>
                <div class="col-12 col-lg-6 col-xl-3 mx-auto">
                    <form class="personal-form">
                        <input type="text" name="TYPE" value="FORGOT" hidden>

                        <h4 class="mb-4 text-center">Пожалуйста, введите E-mail</h4>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="EMAIL" placeholder="E-mail *" required>
                                </div>
                            </div>
                        </div>

                        <div class="personal-error my-4" style="color: red"></div>

                        <button class="btn btn-primary p-3 d-block text-uppercase w-100">Восстановить</button>

                        <div class="row">
                            <div class="col-6">
                                <a href="/personal/register/">Регистрация</a>
                            </div>
                            <div class="col-6 text-right">
                                <a href="/personal/">Войти</a>
                            </div>
                        </div>
                    </form>
                </div>
            <?endif;?>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>