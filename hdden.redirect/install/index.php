<?php
// NOTE this file must compatible with php 5.3

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class hdden_redirect extends CModule
{
	public $MODULE_ID = 'hdden.redirect'; // NOTE using "var" for bitrix rules

	public $MODULE_VERSION;

	public $MODULE_VERSION_DATE;

	public $MODULE_NAME;

	public $MODULE_DESCRIPTION;

	public $MODULE_GROUP_RIGHTS;

	public $PARTNER_NAME;

	public $PARTNER_URI;

	public function __construct()
	{
		$this->MODULE_ID = 'hdden.redirect'; // NOTE for showing module in /bitrix/admin/partner_modules.php?lang=ru

		$arModuleVersion = [];
		include __DIR__ . '/version.php';
		if (!empty($arModuleVersion['VERSION']))
		{
			$this->MODULE_VERSION = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		}

		$this->MODULE_NAME = Loc::getMessage('HDDEN_REDIRECT_MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('HDDEN_REDIRECT_MODULE_DESCRIPTION');
		$this->MODULE_GROUP_RIGHTS = 'Y';

		$this->PARTNER_NAME = 'HDDen';
		$this->PARTNER_URI = 'https://github.com/HDDen/';
	}

	public function InstallFiles()
	{
		return true;
	}

	public function UninstallFiles()
	{
		//...
		return true;
	}

	public function DoInstall()
	{
		global $APPLICATION;
		if (version_compare(PHP_VERSION, '7', '<'))
		{
			$APPLICATION->ThrowException(Loc::getMessage('HDDEN_REQUIREMENTS_PHP_VERSION'));
			return false;
		}
		RegisterModule($this->MODULE_ID);
		RegisterModuleDependences('main', 'OnPageStart', $this->MODULE_ID);
		$this->InstallFiles();
	}

	public function DoUninstall()
	{
		$this->UninstallFiles();
		UnRegisterModuleDependences('main', 'OnPageStart', $this->MODULE_ID);
		UnRegisterModule($this->MODULE_ID);
	}
}
