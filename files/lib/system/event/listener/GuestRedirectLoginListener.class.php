<?php

namespace wcf\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\HeaderUtil;

/**
 * Redirects guests to the login form
 *
 * @author	Florian Gail
 * @copyright	2014 Florian Gail <http://www.mysterycode.de/>
 * @license	Kostenlose Plugins <http://downloads.mysterycode.de/index.php/License/6-Kostenlose-Plugins/>
 * @package	de.mysterycode.wcf.guestredirect
 * @category	WCF
 */
class GuestRedirectLoginListener implements IEventListener {
	/**
	 *
	 * @see \wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!GUEST_REDIRECT_LOGIN)
			return;
		if ($className == 'wcf\form\LoginForm')
			return;
		if ($className == 'wcf\form\RegisterForm')
			return;
		if ($className == 'wcf\form\RegisterActivationForm')
			return;
		if ($className == 'wcf\form\DisclaimerForm')
			return;
		if ($className == 'wcf\form\RegisterNewActivationCodeForm')
			return;
		if ($className == 'wcf\form\LostPasswordForm')
			return;
		if ($className == 'wcf\form\NewPasswordForm')
			return;
		if ($className == 'wcf\page\LegalNoticePage')
			return;
		
		if (WCF::getUser()->userID == 0) {
			HeaderUtil::redirect(LinkHandler::getInstance()->getLink('Login', array()));
			exit;
		}
	}
}
