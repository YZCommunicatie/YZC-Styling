<?php
/*
 *  package: YZC-Styling
 *  copyright: Copyright (c) 2022. Jeroen Moolenschot | YZCommunicatie
 *  license: GNU General Public License version 3 or later
 *  link: https://www.yzcommunicatie.nl
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;

class plgSystemYzcommunicatie extends CMSPlugin
{
    public function onBeforeCompileHead() {
        // Only work in the administrator
        $app = Factory::getApplication();
        if ($app->isClient('site')){
            // Do nothing
            return true;
        }

        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
        $wa->registerAndUseStyle('style', 'https://klanten.yzcommunicatie.nl/custom-login.css');
        return true;
    }


    function onAfterRender() {
        // Only work in the administrator
        $app = Factory::getApplication();
        if ($app->isClient('site')){
            // Do nothing
            return true;
        }

        $body = Factory::getApplication()->getBody();
        $find[] = 'src="'.Uri::getInstance()->root().'media/templates/administrator/atum/images/logos/login.svg';
        $find[] = 'href="index.php?option=com_cpanel&view=cpanel&dashboard=help"';
        $find[] = '<a href="https://docs.joomla.org/Special:MyLanguage/How_do_you_recover_or_reset_your_admin_password%3F" target="_blank" rel="noopener nofollow" title="Open Inloggegevens vergeten? in een nieuw venster">Inloggegevens vergeten?</a>';
        $find[] = '<a href="https://docs.joomla.org/Special:MyLanguage/How_do_you_recover_or_reset_your_admin_password%3F" target="_blank" rel="noopener nofollow" title="Open Forgot your login details? in new window">Forgot your login details?</a>';

        $replace[] = 'src="https://klanten.yzcommunicatie.nl/custom-login-logo.png" width="190px"';
        $replace[] = 'href="https://www.yzcommunicatie.nl/contact" target="_blank"';
        $replace[] = '<a href="https://www.yzcommunicatie.nl/contact" target="_blank" rel="noopener nofollow" title="Heb je een vraag?">Hulp nodig?</a>';
        $replace[] = '<a href="https://www.yzcommunicatie.nl/contact" target="_blank" rel="noopener nofollow" title="Heb je een vraag?">Need help?</a>';

        $body = str_replace($find, $replace, $body);
        Factory::getApplication()->setBody($body);

        return true;
    }
}
