<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <section id="catalog-menu">
        <div class="d-flex mx-1 <?=$arParams['CLASS']?>">
            <?
            foreach($arResult as $arItem):
                if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                    continue;
                ?>
                <a href="<?=$arItem["LINK"]?>" class="<?if($arItem["SELECTED"]):?>active<?endif?>"><?=$arItem["TEXT"]?></a>
            <?endforeach?>
            <!--
            <div class="divider"></div>
            <a href="#" class="d-none d-md-block">new</a>
            <a href="#" class="d-none d-md-block">bestsellers</a>
            <a href="#" class="d-none d-md-block">collections</a>
            <div class="divider d-none d-md-block"></div>
            <a href="#">sort</a>
            <a href="#">filter</a>
            -->
        </div>
    </section>
<?endif?>