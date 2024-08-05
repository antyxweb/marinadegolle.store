<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
        </main>

        <footer id="footer" class="d-flex flex-column">
            <div class="footer-content">
                <a href="/" class="logo">
                    <svg viewBox="0 0 26 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.729 11.8061V8.99594L12.7527 3.21608L2.77437 8.99594V20.5596L12.7527 26.3395L22.729 20.5596V16.171H21.2506V13.3845H25.5034V22.1677L12.7527 29.5556L0 22.1677V7.38791L12.7527 0L25.5034 7.38791V11.8061H22.729ZM18.9887 19.8857V11.3962L20.4691 10.5389L17.8636 9.02945L12.7586 11.9854L7.65358 9.02945L5.03432 10.5409L6.50888 11.3962V19.8817L9.09476 21.3814V12.8958L12.7527 15.0123L16.4008 12.8978V21.3833L18.9887 19.8857Z" fill="white"/>
                    </svg>
                </a>
                <?if($GLOBALS['SETTINGS']['ADDRESS']['VALUES']):?>
                    <p title="<?=$GLOBALS['SETTINGS']['ADDRESS']['NAME']?>"><?=implode('<br/>', $GLOBALS['SETTINGS']['ADDRESS']['VALUES'])?></p>
                <?endif;?>
                <?if($GLOBALS['SETTINGS']['PHONES']['VALUES']):?>
                    <?foreach($GLOBALS['SETTINGS']['PHONES']['VALUES'] as $phone):?>
                        <a href="tel:<?=$phone?>" class="phone" title="<?=$GLOBALS['SETTINGS']['PHONES']['NAME']?>"><?=$phone?></a><br/>
                    <?endforeach;?>
                <?endif;?>
            </div>
        </footer>

        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH;?>/js/vendor/modernizr-3.8.0.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script>
            window.jQuery || document.write('<?=SITE_TEMPLATE_PATH;?>/js/vendor/jquery-3.4.1.min.js"><\/script>');
        </script>

        <script src="<?=SITE_TEMPLATE_PATH;?>/js/scripts.min.js?v<?=time();?>"></script>
        <script src="<?=SITE_TEMPLATE_PATH;?>/js/template.js?v<?=time();?>"></script>
    </body>
</html>