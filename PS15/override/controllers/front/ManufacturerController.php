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
			$id_manufacturer = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
				SELECT `id_manufacturer`
				FROM `'._DB_PREFIX_.'manufacturer`
				WHERE `name` LIKE \''.$name_manufacturer.'\'');

			if($id_manufacturer > 0)
			{
				$_GET['id_manufacturer'] = $id_manufacturer;
				$_GET['noredirect'] = 1;
			}
			else
			{
				Tools::display404Error();
				die;
			}
		}
		parent::init();
	}
}
