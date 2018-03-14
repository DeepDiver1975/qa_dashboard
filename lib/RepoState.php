<?php

namespace OCA\QaDashboard;

class RepoState {

	private $hasDrone = false;
	private $hasCodeCov = true;
	private $hasTravis = true;
	private $hasTravisCom = false;

	public function __construct($name, $branch, array $badges = null) {
		$this->name = $name;
		$this->branch = $branch;
		if ($badges !== null) {
			$this->hasDrone = isset($badges['drone']) ? $badges['drone'] : false;
			$this->hasCodeCov = isset($badges['codecov']) ? $badges['codecov'] : true;
			$this->hasTravis = isset($badges['travis']) ? $badges['travis'] : true;
			$this->hasTravisCom = isset($badges['travis-com']) ? $badges['travis-com'] : false;
		}
	}

	public function getDisplayName() {
		return ucfirst($this->branch);
	}

	public function getBuildStatusBadges() {
		$status = [];
		if ($this->hasDrone) {
			$status[] = [
				// https://drone.owncloud.com/api/repos/owncloud/core/builds/latest?branch=stable10
				'url' => "https://drone.owncloud.com/owncloud/{$this->name}",
				'badge' => "https://drone.owncloud.com/api/badges/owncloud/{$this->name}/status.svg?branch={$this->branch}",
			];
		}

		if ($this->hasTravis) {
			$status[] = [
				'url' => "https://travis-ci.org/owncloud/{$this->name}/",
				'badge' => "https://travis-ci.org/owncloud/{$this->name}.svg?branch={$this->branch}",
			];
		}
		if ($this->hasTravisCom) {
			$status[] = [
				'url' => "https://travis-ci.com/owncloud/{$this->name}/",
				'badge' => "https://travis-ci.com/owncloud/{$this->name}.svg?token=q8ZoWBCat8DFpZ2ALfXP&branch={$this->branch}",
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
		}
		if ($this->name === 'client') {
			$status[] = [
				'url' => "https://jenkins.owncloud.org/job/owncloud-client/job/client/job/{$this->branch}/",
				'badge' => "https://jenkins.owncloud.org/buildStatus/icon?job=owncloud-client/client/{$this->branch}",
			];
			$status[] = [
				'url' => "https://ci.appveyor.com/project/ownclouders/ownclouduniversal/branch/{$this->branch}/",
				'badge' => "https://ci.appveyor.com/api/projects/status/a1x3dslys7de6e21/branch/{$this->branch}?svg=true",
			];
		}
		if ($this->name === 'OwncloudUniversal') {
			$status[] = [
				'url' => "https://ci.appveyor.com/project/DeepDiver1975/ownclouduniversal/branch/{$this->branch}/",
				'badge' => "https://ci.appveyor.com/api/projects/status/rrsqmfv03gos8vmq/branch/{$this->branch}?svg=true",
			];
		}

		while (count($status) < 4) {
			$status[] = [
				'url' => "",
				'badge' => "",
			];
		}

		return $status;
	}
}