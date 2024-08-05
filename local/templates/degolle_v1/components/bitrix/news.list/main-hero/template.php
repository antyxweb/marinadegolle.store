<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<section id="hero">
    <div class="hero-content">
        <div class="row h-100">
            <?foreach($arResult["ITEMS"] as $arKey=>$arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <?if(!$arKey):?>
                    <div class="col-12 col-md-5 col-lg-4 bg-cover h-100 d-flex flex-column" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="hero-left mt-auto">
                            <h3><?=$arItem["PROPERTIES"]["TITLE"]["~VALUE"]?></h3>
                            <p><?=$arItem["PROPERTIES"]["TEXT"]["~VALUE"]?></p>
                        </div>
                        <a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>" class="stretched-link"></a>
                    </div>
                <?else:?>
                    <div class="col-12 col-md-7 col-lg-8 bg-cover h-100 d-none d-md-block" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="hero-right">
                            <svg width="82" height="95" viewBox="0 0 26 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.729 11.8061V8.99594L12.7527 3.21608L2.77437 8.99594V20.5596L12.7527 26.3395L22.729 20.5596V16.171H21.2506V13.3845H25.5034V22.1677L12.7527 29.5556L0 22.1677V7.38791L12.7527 0L25.5034 7.38791V11.8061H22.729ZM18.9887 19.8857V11.3962L20.4691 10.5389L17.8636 9.02945L12.7586 11.9854L7.65358 9.02945L5.03432 10.5409L6.50888 11.3962V19.8817L9.09476 21.3814V12.8958L12.7527 15.0123L16.4008 12.8978V21.3833L18.9887 19.8857Z" fill="#CCBCAD"/>
                            </svg>
                            <h3><?=$arItem["PROPERTIES"]["TITLE"]["~VALUE"]?></h3>
                            <p><?=$arItem["PROPERTIES"]["TEXT"]["~VALUE"]?></p>
                        </div>
                        <a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>" class="stretched-link"></a>
                    </div>
                <?endif;?>
            <?endforeach;?>
        </div>
    </div>
</section>
