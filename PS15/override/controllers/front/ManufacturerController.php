<?php
/*
* 2013 Ha!*!*y
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* It is available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
*
* DISCLAIMER
* This code is provided as is without any warranty.
* No promise of being safe or secure
*
*  @author      Ha!*!*y <ha99ys@gmail.com>
*  @copyright   2012-2013 Ha!*!*y
*  @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  @code sorce: http://prestashop.com
*/

class ManufacturerController extends ManufacturerControllerCore
{
	public function init()
	{
		if (Tools::getValue('manufacturer_rewrite'))
		{
			$name_manufacturer = str_replace('-', '%', Tools::getValue('manufacturer_rewrite'));

			//
			// TODO:: need to core update Prestashop code and 
			// DB for link_rewrite for manufacturers
			// Should we use the Mysql FullText Index Search ??
			//
			$sql = 'SELECT m.`id_manufacturer`, REPLACE(m.`name`,"&","") as manufacturer_name
				FROM `'._DB_PREFIX_.'manufacturer` m
				LEFT JOIN `'._DB_PREFIX_.'manufacturer_shop` s ON (m.`id_manufacturer` = s.`id_manufacturer`)
				WHERE manufacturer_name LIKE \''.$name_manufacturer.'\'';

			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
			{
				$sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
			}

			$manufacturers_list = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
			$manufacturers_count = count($manufacturers_list);

			if($manufacturers_count == 1){
				// Found ONLY one so dont need to check anything
				$id_manufacturer = (int)$manufacturers_list[0]['id_manufacturer'];
				$_GET['noredirect'] = 1;
			} else if($manufacturers_count > 1){
				// Found more than one so ...
				// yeah I actually dont know what to do :(
				// so lets just grab the first one matching
				$id_manufacturer = (int)$manufacturers_list[0]['id_manufacturer'];
			} else {
				// none found
				$id_manufacturer = 0;
			}


			if($id_manufacturer > 0)
			{
				$_GET['id_manufacturer'] = $id_manufacturer;
				$_GET['noredirect'] = 1;
			}
			else
			{
				//TODO: Do we need to send 404?
				header('HTTP/1.1 404 Not Found');
				header('Status: 404 Not Found');
			}
		}
		parent::init();
	}
}
