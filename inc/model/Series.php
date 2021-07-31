<?php

namespace kpiser;

class Series {
	private static $seriesById=NULL;
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

	private static function initSeries() {
		self::$seriesById=array();
		$confs=apply_filters("kpi_series",array());
		foreach ($confs as $conf) {
			$series=new Series($conf);
			self::$seriesById[$series->getId()]=$series;
		}
	}

	public static function getSeries() {
		if (self::$seriesById===NULL)
			self::initSeries();

		return array_values(self::$seriesById);
	}

	public static function getSeriesById($id) {
		if (self::$seriesById===NULL)
			self::initSeries();

		if (!array_key_exists($id,self::$seriesById))
			return NULL;

		return self::$seriesById[$id];
	}
}
