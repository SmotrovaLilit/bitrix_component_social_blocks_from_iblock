<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$fail = function ($meaasge) {
    echo "<p>" . $meaasge;
    exit;
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
$iblockCode = "sbl_social_links";
$iblockTypeId = "sbl_social_links";
CModule::IncludeModule("iblock");
$iblockTypeId = "sbl_social_links";
$arFieldsIType = array(
    "ID" => $iblockTypeId,
    "SORT" => "500",
    "SECTIONS" => "", //включает секции
    "EDIT_FILE_BEFORE" => "",//Файл для редактирования элемента, позволяющий модифицировать поля перед сохранением
    "EDIT_FILE_AFTER" => "",//Файл с формой редактирования элемента
    "LANG" => array(
        "ru" => array(
            "NAME" => "Ссылки на группы в соц сетях",
            "ELEMENT_NAME" => "Ссылки на группы в соц сетях"
        ),
        "en" => array(
            "NAME" => "Social links",
            "ELEMENT_NAME" => "Social links"
        )
    )
);
$typeBd = CIBlockType::GetList(array(), array(
    "ID" => $iblockTypeId,
));
$iblType = new CIBlockType();
if ($iblTypeExist = $typeBd->Fetch()) {
    if (!$iblType->Update($iblTypeExist["ID"], $arFieldsIType)) {
        $fail("Не удалось обновить тип инфоблока " . $iblType->LAST_ERROR);
    }
    $success("Тип инфоблока обновлен");
} else {
    if (!$iblType->Add($arFieldsIType)) {
        $fail("Не удалось добавить тип инфоблока " . $iblType->LAST_ERROR);
    }
    $success("Тип инфоблока добавлен");
}

//инфоблок
$iblockFields = array(
    "CODE" => array(
        "IS_REQUIRED" => "Y",
        "DEFAULT_VALUE" => array(
            "UNIQUE" => "Y",
            "TRANSLITERATION" => "Y",
            "TRANS_LEN" => "100",
            "TRANS_CASE" => "Y",
            "TRANS_SPACE" => "-",
            "TRANS_OTHER" => "-",
            "TRANS_EAT" => "Y"
        )
    )
);
$arFieldsIbl = array(
    "ACTIVE" => "Y",
    "NAME" => "Ссылки на группы соц сетей",
    "CODE" => $iblockCode,
    "LIST_PAGE_URL" => "#SITE_DIR#/sbl_social_links/index.php?ID=#IBLOCK_ID#",
    "DETAIL_PAGE_URL" => "#SITE_DIR#/sbl_social_links/detail.php?ID=#ELEMENT_ID#",
    "CANONICAL_PAGE_URL" => "",
    "INDEX_ELEMENT" => "N", //Индексировать элементы для модуля поиска
    "IBLOCK_TYPE_ID" => $iblockTypeId,
    "LID" => array(
        SITE_ID
    ),
    "SORT" => "500",
    "PICTURE" => array(),
    "DESCRIPTION" => "",
    "DESCRIPTION_TYPE" => "",
    "EDIT_FILE_BEFORE" => "", //Файл для редактирования элемента, позволяющий модифицировать поля перед сохранением:
    "EDIT_FILE_AFTER" => "",//Файл с формой редактирования элемента:
    "WORKFLOW" => "N",
    "BIZPROC" => "N",
    "SECTION_CHOOSER" => "L", //Интерфейс привязки элемента к разделам
    "LIST_MODE" => "",
    "FIELDS" => $iblockFields,
    "ELEMENTS_NAME" => "Элементы",
    "ELEMENT_NAME" => "Элемент",
    "ELEMENT_ADD" => "Добавить элемент",
    "ELEMENT_EDIT" => "Изменить элемент",
    "ELEMENT_DELETE" => "Удалить элемент",
    "RIGHTS_MODE" => "S", //Расширенное управление правами
    "GROUP_ID" => array(
        "2" => "R",
        "1" => "X"
    ),
    "IPROPERTY_TEMPLATES" => array(

    ),
    "VERSION" => 1,

);
$iblockBD = CIBlock::GetList(array(), array(
    "CODE" => $iblockCode,
));
$ibl = new CIBlock();
if ($iblExist = $iblockBD->Fetch()) {
    if (!$ibl->Update($iblExist["ID"], $arFieldsIbl)) {
        $fail("Не удалось обновить инфоблок " . $ibl->LAST_ERROR);
    }
    $success("инфоблок обновлен");
} else {
    if (!$ibl->Add($arFieldsIbl)) {
        $fail("Не удалось добавить инфоблок " . $ibl->LAST_ERROR);
    }
    $success("Инфоблок добавлен");
}

//свойства
$iblId = $getIblIdByCode($iblockCode);
$iblPropertyFields[] = array(
    "NAME" => "Ссылка",
    "SORT" => "500",
    "CODE" => "LINK",
    "MULTIPLE" => "N",
    "IS_REQUIRED" => "Y",
    "ACTIVE" => "Y",
    "PROPERTY_TYPE" => "S",
    "IBLOCK_ID" => $iblId,
    "LIST_TYPE" => "L",
    "ROW_COUNT" => 1,
    "COL_COUNT" => 30,
    "USER_TYPE" => "",
    "FILE_TYPE" => "",
    "LINK_IBLOCK_ID" => "",
    "DEFAULT_VALUE" => "",
    "USER_TYPE_SETTINGS" => array(),
    "WITH_DESCRIPTION" => "N",
    "SEARCHABLE" => "N",
    "FILTRABLE" => "N",
    "MULTIPLE_CNT" => 5,
    "HINT" => "",
    "VALUES" => array(),
    "SECTION_PROPERTY" => "Y",
    "SMART_FILTER" => "N",
    "DISPLAY_TYPE" => "",
    "DISPLAY_EXPANDED" => "N",
    "FILTER_HINT" => "",
);
$iblPropertyFields[] = array(
    "NAME" => "CSS класс",
    "SORT" => "500",
    "CODE" => "CSS_CLASS",
    "MULTIPLE" => "N",
    "IS_REQUIRED" => "N",
    "ACTIVE" => "Y",
    "PROPERTY_TYPE" => "S",
    "IBLOCK_ID" => $iblId,
    "LIST_TYPE" => "L",
    "ROW_COUNT" => 1,
    "COL_COUNT" => 30,
    "USER_TYPE" => "",
    "FILE_TYPE" => "",
    "LINK_IBLOCK_ID" => "",
    "DEFAULT_VALUE" => "",
    "USER_TYPE_SETTINGS" => array(),
    "WITH_DESCRIPTION" => "N",
    "SEARCHABLE" => "N",
    "FILTRABLE" => "N",
    "MULTIPLE_CNT" => 5,
    "HINT" => "",
    "VALUES" => array(),
    "SECTION_PROPERTY" => "Y",
    "SMART_FILTER" => "N",
    "DISPLAY_TYPE" => "",
    "DISPLAY_EXPANDED" => "N",
    "FILTER_HINT" => "",
);
foreach ($iblPropertyFields as $item) {
    $propertCode = $item["CODE"];
    $dbList = CIBlockProperty::GetList(array(), array(
        "CODE" => $propertCode,
        "IBLOCK_ID" => $iblId
    ));
    $obIblProperty = new CIBlockProperty();
    if ($data = $dbList->Fetch()) {
        if (!$obIblProperty->Update($data["ID"], $item)) {
            $fail(sprintf("Не удалось обновить свосйтво %s. Ошибка- %s",
                $propertCode,
                $obIblProperty->LAST_ERROR
            ));
        }
        $success(sprintf("Свойство %s обновлено" , $propertCode));
    } else {
        if (!$obIblProperty->Add($item)) {
            $fail(sprintf("Не удалось добавить свойство %s. Ошибка- %s",
                $propertCode,
                $obIblProperty->LAST_ERROR
            ));
        }
        $success(sprintf("Свойство %s добавлено" , $propertCode));
    }
}

