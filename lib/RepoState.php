<?php

namespace OCA\QaDashboard;

class RepoState {

	private $hasCodeCov = true;
	private $hasTravis = true;

	public function __construct($name, $branch) {
		$this->name = $name;
		$this->branch = $branch;
	}

	public function getDisplayName() {
		return ucfirst($this->branch);
	}

	public function getBuildStatusBadges() {
		$status = [ [
			// https://drone.owncloud.com/api/repos/owncloud/core/builds/latest?branch=stable10
			'url' => "https://drone.owncloud.com/owncloud/{$this->name}",
			'badge' => "https://drone.owncloud.com/api/badges/owncloud/{$this->name}/status.svg?branch={$this->branch}",
			]];

		if ($this->hasTravis) {
			$status[] = [
				'url' => "https://travis-ci.org/owncloud/{$this->name}/",
				'badge' => "https://travis-ci.org/owncloud/{$this->name}.svg?branch={$this->branch}",
			];
		}
		if ($this->hasCodeCov) {
			$status[] = [
				'url' => "https://codecov.io/gh/owncloud/{$this->name}/",
				'badge' => "https://codecov.io/gh/owncloud/{$this->name}/branch/{$this->branch}/graph/badge.svg",
			];
		}
		if ($this->name === 'core') {
			$status[] = [
				'url' => "https://jenkins.owncloud.org/job/owncloud-core/job/core/job/{$this->branch}/",
				'badge' => "https://jenkins.owncloud.org/buildStatus/icon?job=owncloud-core/core/{$this->branch}",
			];
		} else {
			$status[] = [
				'url' => "",
				'badge' => "",
			];

		}

		return $status;
	}
}