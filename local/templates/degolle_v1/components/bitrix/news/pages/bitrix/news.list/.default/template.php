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

$lastGallery = 0;
?>

<?foreach($arResult["ITEMS"] as $arKey=>$arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

    $lastGallery = 0;
    if($arItem["PROPERTIES"]['GALLERY']['VALUE'] && !$arItem["PREVIEW_TEXT"]) {
        $lastGallery = count($arItem["PROPERTIES"]['GALLERY']['VALUE']);
    }
    ?>
    <div id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <?if($arItem["PROPERTIES"]['GALLERY']['VALUE']):?>
            <?if(count($arItem["PROPERTIES"]['GALLERY']['VALUE']) == 1):?>
                <div class="picture-frame-left picture-frame-right picture-frame-bottom">
                    <img src="<?=CFile::GetPath($arItem["PROPERTIES"]['GALLERY']['VALUE'][0])?>" alt="<?echo $arItem["NAME"];?>">
                </div>
            <?elseif(count($arItem["PROPERTIES"]['GALLERY']['VALUE']) == 2):?>
                <div class="picture-frame-bottom">
                    <img src="<?=CFile::GetPath($arItem["PROPERTIES"]['GALLERY']['VALUE'][0])?>" alt="<?echo $arItem["NAME"];?>" class="d-md-none">
                    <img src="<?=CFile::GetPath($arItem["PROPERTIES"]['GALLERY']['VALUE'][1])?>" alt="<?echo $arItem["NAME"];?>" class="d-none d-md-block">
                </div>
            <?else:?>
                <div class="main-carousel-50">
                    <?foreach ($arItem["PROPERTIES"]['GALLERY']['VALUE'] as $pic):?>
                        <div class="carousel-cell bg-cover" style="background-image: url('<?=CFile::GetPath($pic)?>')">
                            <img src="<?=CFile::GetPath($pic)?>">
                        </div>
                    <?endforeach;?>
                </div>
            <?endif;?>
        <?endif;?>

        <?if($arItem["PREVIEW_TEXT"]):?>
            <section class="text-content <?if($arKey):?>line-top<?endif;?>">
                <div class="container-fluid">
                    <?echo $arItem["PREVIEW_TEXT"];?>
                </div>
            </section>
        <?endif;?>
    </div>
<?endforeach;?>

<?if($lastGallery > 2):?>
    <section class="text-content line-top"></section>
<?endif;?>
