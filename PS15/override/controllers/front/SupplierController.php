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

class SupplierController extends SupplierControllerCore
{
	public function init()
	{
		if (Tools::getValue('supplier_rewrite'))
		{
			$name_supplier = str_replace('-', '%', Tools::getValue('supplier_rewrite'));

			//
			// TODO:: need to core update Prestashop code and 
			// DB for link_rewrite for suppliers
			// Should we use the Mysql FullText Index Search ??
			//
			$sql = 'SELECT sp.`id_supplier`
				FROM `'._DB_PREFIX_.'supplier` sp
				LEFT JOIN `'._DB_PREFIX_.'supplier_shop` s ON (sp.`id_supplier` = s.`id_supplier`)
				WHERE sp.`name` LIKE \''.$name_supplier.'\'';

			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
			{
				$sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
			}

			$id_supplier = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

			if($id_supplier > 0)
			{
				$_GET['id_supplier'] = $id_supplier;
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
