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

class ProductController extends ProductControllerCore
{
	public function init()
	{
		if (Tools::getValue('product_rewrite'))
		{
			//$url_id_pattern = '/[a-zA-Z0-9-]*\/([0-9]+)\-([a-zA-Z0-9-]*)\.html/';
			$url_id_pattern = '/.*?([0-9]+)\-([a-zA-Z0-9-]*)\.html/';
			$rewrite_url = Tools::getValue('product_rewrite');

			$id_product = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
				SELECT `id_product`
				FROM `'._DB_PREFIX_.'product_lang`
				WHERE `link_rewrite` = \''.$rewrite_url.'\'');

			if($id_product > 0)
			{
				$_GET['id_product'] = $id_product;
			}
			else if(preg_match($url_id_pattern, $_SERVER['REQUEST_URI'], $url_split))
			{
				$url_id_product = $url_split[1];

				$id_product = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
					SELECT `id_product`
					FROM `'._DB_PREFIX_.'product_lang`
					WHERE `id_product` = \''.$url_id_product.'\'');

				if($id_product > 0)
				{
					$_GET['id_product'] = $id_product;
				}
				else
				{
					Tools::display404Error();
					die;
				}
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
