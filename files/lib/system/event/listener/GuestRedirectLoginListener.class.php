<?php

namespace wcf\system\event\listener;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\HeaderUtil;

/**
 * Redirects guests to the login form
 *
 * @author       Florian Gail
 * @copyright    2014 Florian Gail <http://www.mysterycode.de/>
 * @license      Kostenlose Plugins <http://downloads.mysterycode.de/index.php/License/6-Kostenlose-Plugins/>
 * @package      de.mysterycode.wcf.guestredirect
 * @category     WCF
 */
class GuestRedirectLoginListener implements IParameterizedEventListener {
	/**
	 * @inheritDoc
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
		if (!GUEST_REDIRECT_LOGIN) return;

		if (in_array($className, ['wcf\form\LoginForm', 'wcf\form\RegisterForm', 'wcf\form\RegisterActivationForm', 'wcf\form\DisclaimerForm', 'wcf\form\RegisterNewActivationCodeForm', 'wcf\form\LostPasswordForm', 'wcf\form\NewPasswordForm', 'wcf\page\LegalNoticePage'])) {
			return;
		}

		$excludeString = GUEST_REDIRECT_EXCLUDES;
		if (!empty($excludeString)) {
			$controllers = explode('\n', $excludeString);

			if (in_array($className, $controllers)) return;
		}

		if (!WCF::getUser()->userID) {
			HeaderUtil::redirect(LinkHandler::getInstance()->getLink('Login'));
			exit;
		}
	}
}
