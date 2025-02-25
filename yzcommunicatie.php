<?php
/*
 *  package: YZC-Styling
 *  copyright: Copyright (c) 2025. Jeroen Moolenschot | YZCommunicatie
 *  license: GNU General Public License version 3 or later
 *  link: https://www.yzcommunicatie.nl
 */

// No direct access to this file
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;

/**
 *
 */
class plgSystemYzcommunicatie extends CMSPlugin
{
	/**
	 * Application object.
	 *
	 * @var    JApplicationCms
	 * @since  1.0.0
	 */
	protected $app;

	/**
	 * Constructor
	 *
	 * @param   object  $subject  The object to observe
	 * @param   array   $config   An optional associative array of configuration settings.
	 *                            Recognized key values include 'name', 'group', 'params', 'language'
	 *                            (this list is not meant to be comprehensive).
	 *
	 * @since   1.0.0
	 */
	public function __construct(&$subject, array $config = array())
	{
		parent::__construct($subject, $config);
	}

	public function onBeforeCompileHead()
	{
		// Only for administrator
		if (!$this->app->isClient('administrator'))
		{
			return;
		}

		$wa = $this->app->getDocument()->getWebAssetManager();
		$wa->registerAndUseStyle('style', 'https://klanten.yzcommunicatie.nl/custom-login.css');
	}

	function onAfterRender()
	{
		// Only for administrator
		if (!$this->app->isClient('administrator'))
		{
			return;
		}

		$body   = $this->app->getBody();
		$find[] = 'src="' . Uri::getInstance()->root() . 'media/templates/administrator/atum/images/logos/login.svg';
		$find[] = 'href="index.php?option=com_cpanel&view=cpanel&dashboard=help"';
		$find[] = '<a href="https://docs.joomla.org/Special:MyLanguage/How_do_you_recover_or_reset_your_admin_password%3F" target="_blank" rel="noopener nofollow" title="Open Inloggegevens vergeten? in een nieuw venster">Inloggegevens vergeten?</a>';
		$find[] = '<a href="https://docs.joomla.org/Special:MyLanguage/How_do_you_recover_or_reset_your_admin_password%3F" target="_blank" rel="noopener nofollow" title="Open Forgot your login details? in new window">Forgot your login details?</a>';

		$replace[] = 'src="https://klanten.yzcommunicatie.nl/custom-login-logo.png" width="190px"';
		$replace[] = 'href="https://www.yzcommunicatie.nl/contact" target="_blank"';
		$replace[] = '<a href="https://www.yzcommunicatie.nl/contact" target="_blank" rel="noopener nofollow" title="Heb je een vraag?">Hulp nodig?</a>';
		$replace[] = '<a href="https://www.yzcommunicatie.nl/contact" target="_blank" rel="noopener nofollow" title="Heb je een vraag?">Need help?</a>';

		$body = str_replace($find, $replace, $body);
		$this->app->setBody($body);
	}

	public function onContentPrepare()
	{
		// Only for frontend
		if (!$this->app->isClient('site'))
		{
			return;
		}

		$themecolor = $this->params->get('themecolor', '#ffffff');
		$doc        = $this->app->getDocument();
		$doc->setMetaData('theme-color', $themecolor);

		// SET HOMEPAGE PAGETITLE
		$menu     = $this->app->getMenu();
		$language = $this->app->getLanguage();
		$siteName = $this->app->getConfig()->get('sitename');

		if ($menu->getActive() == $menu->getDefault($language->getTag()))
		{
			if ($this->params->get('homepagetitle'))
			{
				$doc->setTitle($this->params->get('homepagetitle'));
			}
			else
			{
				$doc->setTitle($siteName);
			}
		}

		// SET CANONICAL URL
		$link = Uri::getInstance()->toString();
		$link = rtrim($link, '/');
		$link = strtok($link, '?');
		$doc->addHeadLink($link, 'canonical');
	}
}
