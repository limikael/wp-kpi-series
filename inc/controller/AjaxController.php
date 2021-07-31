<?php

namespace kpiser;

require_once __DIR__."/../utils/AjaxHandler.php";

class AjaxController extends AjaxHandler {
	protected function __construct() {
		parent::__construct("kpi-series");
	}

	public function getSeriesData($p) {
		$series=Series::getSeriesById($p["series"]);
		$firstDay=$p["month"]."-01";
		$lastDay=date("Y-m-t",strtotime($firstDay));
		$uptoDay=date("Y-m-t",strtotime($firstDay)+24*60*60);

		$range=array(
			"firstDay"=>$firstDay,
			"lastDay"=>$lastDay,
			"uptoDay"=>$uptoDay
		);

		return array(
			"data"=>$series->getDataForRange($range),
			"xMin"=>$firstDay,
			"xMax"=>$lastDay,
		);
	}
}
