<?php

namespace kpiser;

require_once __DIR__."/../utils/Singleton.php";
require_once __DIR__."/../utils/Template.php";
require_once __DIR__."/../utils/HtmlUtil.php";
require_once __DIR__."/../model/Series.php";
require_once __DIR__."/../controller/AjaxController.php";

class KpiSerPlugin extends Singleton {
	private $seriesById;

	protected function __construct() {
		add_action("admin_menu",array($this,"admin_menu"));
		add_action("admin_enqueue_scripts",array($this,"enqueue_scripts"));

		AjaxController::instance();
	}

	public function enqueue_scripts() {
		wp_enqueue_script("chartjs",
			"https://cdn.jsdelivr.net/npm/chart.js",
			array(),"fixme",true);

		wp_enqueue_script("moment",
			"https://cdn.jsdelivr.net/npm/moment@2.27.0",
			array(),"fixme",true);

		wp_enqueue_script("chartjs-moment",
			"https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@0.1.1",
			array(),"fixme",true);

		wp_enqueue_script("kpiseries",
			KPISER_URL."/res/wp-kpi-series.js",
			array("chartjs","moment","chartjs-moment","jquery"),"fixme",true);
	}

	public function getEpoch() {
		global $wpdb;
		return $wpdb->get_var(
			"SELECT min(user_registered) ".
			"FROM   {$wpdb->prefix}users"
		);
	}

	public function nextMonth($t) {
		$lastDay=date("Y-m-t",$t);
		return strtotime($lastDay)+24*60*60;
	}

	public function admin_kpi_page() {
		$tpl=new Template(__DIR__."/../tpl/admin-kpis.tpl.php");
		$serSelectOptions=array();

		foreach (Series::getSeries() as $series)
			$serSelectOptions[$series->getId()]=$series->getTitle();

		$m=array();
		$epoch=strtotime($this->getEpoch());
		for ($t=$epoch; $t<time(); $t=$this->nextMonth($t)) {
			$key=date("Y-m",$t);
			$label=date("M, Y",$t);
			$m[$key]=$label;
		}

		$monthSelectOptions=array();
		foreach (array_reverse(array_keys($m)) as $k)
			$monthSelectOptions[$k]=$m[$k];

		$tpl->display(array(
			"serSelectOptions"=>$serSelectOptions,
			"monthSelectOptions"=>$monthSelectOptions
		));
	}

	public function admin_menu() {
		add_options_page(
			"KPIs",
			"KPIs",
			'manage_options',
			'kpis',
			array($this,"admin_kpi_page")
		);
	}
}
