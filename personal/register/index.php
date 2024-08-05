<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Регистрация");
$APPLICATION->SetTitle("Регистрация");

global $USER;
if($USER->IsAuthorized()) {
    LocalRedirect('/personal/');
}
?>
    <section id="cart">
        <div class="row">
            <div class="col-12 col-lg-6 col-xl-3 mx-auto">
                <form class="personal-form">
                    <input type="text" name="TYPE" value="REGISTER" hidden>

                    <h4 class="mb-4 text-center">Пожалуйста, заполните форму ниже</h4>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="NAME" placeholder="Имя *" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="email" class="form-control" name="EMAIL" placeholder="E-mail *" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="password" class="form-control" name="PASSWORD" placeholder="Пароль *" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="CONFIRM_PASSWORD" placeholder="Повторите пароль *" required>
                            </div>
                        </div>
                    </div>

                    <div class="personal-error my-4" style="color: red"></div>

                    <button class="btn btn-primary p-3 d-block text-uppercase w-100">Зарегистрироваться</button>

                    <div class="row">
                        <div class="col-6">
                            <a href="/personal/">Войти</a>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/personal/forgot/">Забыли пароль</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>