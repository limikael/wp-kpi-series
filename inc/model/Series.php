<?php

namespace kpiser;

class Series {
	private $conf;

	public function __construct($conf) {
		if (!$conf["id"])
			throw new \Exception("Series doesn't have an id");

		$this->conf=$conf;
	}

	public function getId() {
		return $this->conf["id"];
	}

	public function getTitle() {
		return $this->conf["title"];
	}

	public function getDataForRange($range) {
		return $this->conf["data_cb"]($range);
	}
}
