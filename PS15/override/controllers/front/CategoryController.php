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

class CategoryController extends CategoryControllerCore
{
	public function init()
	{
		if (Tools::getValue('category_rewrite'))
		{
			$category_rewrite = Tools::getValue('category_rewrite');

			$id_category = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
				SELECT `id_category`
				FROM `'._DB_PREFIX_.'category_lang`
				WHERE `link_rewrite` = \''.$category_rewrite.'\'');

			if($id_category > 0)
			{
				$_GET['id_category'] = $id_category;
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
