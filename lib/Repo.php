<?php

namespace OCA\QaDashboard;

class Repo {

	public function __construct($name, array $branches = ['master']) {
		$this->name = $name;
		$this->branches = array_map(function($branch) {
			return new RepoState($this->name, $branch);
		}, $branches);
	}

	public function getDisplayName() {
		return ucfirst($this->name);
	}

	public function getRepoLink() {
		return "https://github.com/owncloud/{$this->name}";
	}

	public function getBranches() {
		return $this->branches;
	}
}