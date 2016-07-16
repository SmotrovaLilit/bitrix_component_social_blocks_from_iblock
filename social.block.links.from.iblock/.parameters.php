<? use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if(!CModule::IncludeModule("iblock"))
    return;
Loc::loadMessages(__FILE__);

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = $arRes["NAME"];
$arSorts = array("ASC"=>Loc::getMessage("SBL_DESC_ASC"), "DESC"=>Loc::getMessage("SBL_DESC_DESC"));
$arSortFields = array(
    "ID" => Loc::getMessage("SBL_DESC_FID"),
    "NAME" => Loc::getMessage("SBL_DESC_FNAME"),
    "ACTIVE_FROM" => Loc::getMessage("SBL_DESC_FACT"),
    "SORT" => Loc::getMessage("SBL_DESC_FSORT"),
);

$arComponentParameters = array(
    "PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("SBL_DESC_LIST_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "DEFAULT" => "",
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("SBL_DESC_LIST_ID"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ),
        "SORT_BY1" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => Loc::getMessage("SBL_DESC_IBORD1"),
            "TYPE" => "LIST",
            "DEFAULT" => "ACTIVE_FROM",
            "VALUES" => $arSortFields,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_ORDER1" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => Loc::getMessage("SBL_DESC_IBBY1"),
            "TYPE" => "LIST",
            "DEFAULT" => "DESC",
            "VALUES" => $arSorts,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "CACHE_TIME"  =>  array("DEFAULT"=>36000000),
    )
);
?>