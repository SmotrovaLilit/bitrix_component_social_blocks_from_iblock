
### Пример использования ###


```
#!php

 <? $APPLICATION->IncludeComponent(
	"ws:social.block.links.from.iblock", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "sbl_social_links",
		"IBLOCK_ID" => "8",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000"
	),
	false
); ?>
```


### Миграции для создания инфоблока? ###

migrations / migrate.php

### Миграции для заполнения инфоблока ###

migrations / migrate_element.php
