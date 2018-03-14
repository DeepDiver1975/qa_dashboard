<?php
/**
 * ownCloud - qa
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Thomas Müller <thomas.mueller@tmit.eu>
 * @copyright Thomas Müller 2018
 */

namespace OCA\QaDashboard\Controller;

use OCA\QaDashboard\Repo;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;

class PageController extends Controller {

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @PublicPage
	 */
	public function index() {

		$dashboard = $this->readConfig();

		usort($dashboard , function(Repo $a, Repo $b) {
			return $a->getDisplayName() >= $b->getDisplayName();
		});
		$params = [
			'dashboard' => $dashboard
		];
		$template = new TemplateResponse('qa_dashboard', 'main', $params);

		$policy = new ContentSecurityPolicy();
		$policy->addAllowedImageDomain('https://drone.owncloud.com');
		$policy->addAllowedImageDomain('https://jenkins.owncloud.org');
		$policy->addAllowedImageDomain('https://codecov.io');
		$policy->addAllowedImageDomain('https://travis-ci.org');
		$policy->addAllowedImageDomain('https://*.travis-ci.org');
		$policy->addAllowedImageDomain('https://ci.appveyor.com');
		$template->setContentSecurityPolicy($policy);

		return $template;
	}

	/**
	 * @return array
	 */
	public function readConfig() {
		$data = json_decode(file_get_contents( __DIR__ . '/config.json'), true);

		$dashboard = array_map(function ($elem) {
			$branches = isset($elem['branches']) ? $elem['branches']: ['master'];
			$badges = isset($elem['badges']) ? $elem['badges']: null;
			return new Repo($elem['repo'], $branches, $badges);
		}, $data);
		return $dashboard;
	}
}
