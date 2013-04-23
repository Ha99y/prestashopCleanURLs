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

class cleanurls extends Module
{
	public function __construct()
	{
		$this->name = 'cleanurls';
		$this->tab = 'seo';
		$this->version = '0.3.1';
		$this->author = 'ha!*!*y';

		parent::__construct();

		$this->displayName = $this->l('Clean URLs');
		$this->description = $this->l('This override allows you to remove URL ID\'s.');
	}

	public function getContent()
	{
		$output = 'You need to fix duplicate URL entries<br/>';

		$sql = 'SELECT * FROM `'._DB_PREFIX_.'product_lang` WHERE `link_rewrite` in (SELECT `link_rewrite` FROM `'._DB_PREFIX_.'product_lang` GROUP BY `link_rewrite`, `id_lang` HAVING count(`link_rewrite`) > 1)';

		if ($results = Db::getInstance()->ExecuteS($sql))
		{
			foreach ($results AS $row)
			{
				$output .= $row['name'].' ('.$row['id_product'] .') - '. $row['link_rewrite'].'<br/>';
			}
		}
		else
		{
			$output = 'Nice you don\'t have any duplicate URL entries.';
		}

		return $output;
	}

	public function install()
	{
		if (!parent::install())
			return false;
		return true;
	}

	public function uninstall()
	{
		if (!parent::uninstall())
			return false;
		return true;
	}
}
