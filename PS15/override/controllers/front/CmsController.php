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

class CmsController extends CmsControllerCore
{
	public function init()
	{
		if (Tools::getValue('cms_rewrite'))
		{
			$rewrite_url = Tools::getValue('cms_rewrite');

			$sql = 'SELECT l.`id_cms`
				FROM `'._DB_PREFIX_.'cms_lang` l
				LEFT JOIN `'._DB_PREFIX_.'cms_shop` s ON (l.`id_cms` = s.`id_cms`)
				WHERE l.`link_rewrite` = \''.$rewrite_url.'\'';

			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
			{
				$sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
			}

			$id_cms = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

			if($id_cms > 0)
			{
				$_GET['id_cms'] = $id_cms;
			}
			else
			{
				//TODO: Do we need to send 404?
				header('HTTP/1.1 404 Not Found');
				header('Status: 404 Not Found');
			}
		}
		else if (Tools::getValue('cms_category_rewrite'))
		{
			$rewrite_url = Tools::getValue('cms_category_rewrite');

			$sql = 'SELECT `id_cms_category`
				FROM `'._DB_PREFIX_.'cms_category_lang`
				WHERE `link_rewrite` = \''.$rewrite_url.'\'';

			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
			{
				$sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
			}

			$id_cms_category = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

			if($id_cms_category > 0)
			{
				$_GET['id_cms_category'] = $id_cms_category;
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
