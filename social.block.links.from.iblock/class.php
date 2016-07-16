<?php
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;


class SocialBlocksLinksFromIblock extends CBitrixComponent {

    public function onPrepareComponentParams($arParams)
    {
        if(!isset($arParams["CACHE_TIME"]))
            $arParams["CACHE_TIME"] = 36000000;

        $arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
        $arParams["IBLOCK_ID"] = trim($arParams["IBLOCK_ID"]);
        $arParams["SORT_BY1"] = trim($arParams["SORT_BY1"]);
        if(strlen($arParams["SORT_BY1"])<=0)
            $arParams["SORT_BY1"] = "ACTIVE_FROM";
        if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER1"]))
            $arParams["SORT_ORDER1"]="DESC";
        return $arParams;
    }
    
    public function executeComponent () {
        if(strlen($this->arParams["IBLOCK_TYPE"])<=0) {
            ShowError(Loc::getMessage("SBL_VALID_IBLOCK_TYPE"));
            return;
        }
        if(strlen($this->arParams["IBLOCK_ID"])<=0) {
            ShowError(Loc::getMessage("SBL_VALID_IBLOCK_ID"));
            return;
        }
        if(!Loader::includeModule("iblock"))
        {
            $this->abortResultCache();
            ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
            return;
        }
        if ($this->StartResultCache()) {
            $this->arResult["ITEMS"] = $this->getItems();
            $this->includeComponentTemplate();
        }
    }

    private function getItems() {
        $elementsDb = CIBlockElement::GetList(
            array($this->arParams["SORT_BY1"] => $this->arParams["SORT_ORDER1"]),
            $this->getFilter(),
            false,
            false,
            $this->getSelect()
        );
        
        $items = array();
        while ($element= $elementsDb->Fetch()) {
            $item["CSS_CLASS"] = $element["PROPERTY_CSS_CLASS_VALUE"];
            $item["LINK"] = $element["PROPERTY_LINK_VALUE"];
            $item["PREVIEW_PICTURE"] = $element["PREVIEW_PICTURE"];
            $item["NAME"] = $element["NAME"];
            $item["CODE"] = $element["CODE"];
            $items[] = $item;
        }
        
        return $items;
    } 
    
    private function getFilter() {
        return array(
            "!PROPERTY_LINK" => false,
            "ACTIVE" => "Y",
            "ACTIVE_DATE" => "Y",
        );
    }

    private function getSelect() {
        return array(
            "NAME",
            "CODE",
            "PREVIEW_PICTURE",
            "PROPERTY_CSS_CLASS",
            "PROPERTY_LINK",
        );
    }
}