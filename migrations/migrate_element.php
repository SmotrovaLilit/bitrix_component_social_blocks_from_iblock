<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
$fail = function ($meaasge, $exit = true) {
    echo "<p>" . $meaasge;
    if ($exit) {
        exit;
    }
};
$success = function ($meaasge, $exit = false) {
    echo "<p>" . $meaasge;
    if ($exit) {
        exit;
    }
};
$getIblIdByCode = function ($iblockCode) use ($fail) {
    $iblockBD = CIBlock::GetList(array(), array(
        "CODE" => $iblockCode,
    ));

    if ($iblExist = $iblockBD->Fetch()) {
        return $iblExist["ID"];
    } else {
        $fail("Не найден инфоблок с кодом " . $iblockCode);
    }

    return false;
};

$iblCode = "sbl_social_links";
$iblId = $getIblIdByCode($iblCode);
$elements_data = array(
    array(
        "NAME" => "facebook",
        "PROPERTY_VALUES" => array(
            "LINK" => "https://www.facebook.com/lilit.babayan.986",
            "CSS_CLASS" => "",
        )
    ),    
    array(
        "NAME" => "twitter",
        "PROPERTY_VALUES" => array(
            "LINK" => "",
            "CSS_CLASS" => "",
        )
    ),
    array(
        "NAME" => "vk",
        "PROPERTY_VALUES" => array(
            "LINK" => "https://new.vk.com/blilitm",
            "CSS_CLASS" => "",
        )
    )
);
$elements = array();
foreach ($elements_data as  &$elementData) {
    if (!$elementData["CODE"]) {
        $elementData["CODE"] = CUtil::translit($elementData["NAME"],"ru");
    }

    $elementData["IBLOCK_ID"] = $iblId;
    $elements[$elementData["CODE"]] = $elementData;
}

$result = CIBlockElement::GetList(
    array(),
    array(
        "CODE" => array_column($elements, "CODE"),
        "IBLOCK_ID" => $iblId
    ),
    false,
    false,
    array('ID', 'IBLOCK_ID', 'CODE')
);

$element = new CIBlockElement();
while ($existElement = $result->Fetch()) {
    if ($element->Update($existElement['ID'], $elements[$existElement['CODE']])) {
        $success("Обновлен элемент " . $elements[$existElement['CODE']]["NAME"]);
    } else {
        $fail("Не удалось обновить элемент " . $elements[$existElement['CODE']]["NAME"] . " " .  $element->LAST_ERROR, false);
    }
    unset($elements[$existElement['CODE']]);
}

foreach ($elements as $item) {
    if ($element->Add($item)) {
        $success(" Добавлен элемент " . $item["NAME"]);
        continue;
    }
    $fail(" Не удалось добавить элемент " . $item["NAME"] . " " .  $element->LAST_ERROR, false);
}