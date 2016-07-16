<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<div class="social-box">
    <?php foreach ($arResult["ITEMS"] as $item) : ?>
        <a target="_blank" href="<?=$item["LINK"]?>" class="social-itam <?=$item["CSS_CLASS"]?>"></a>
    <? endforeach; ?>
</div>