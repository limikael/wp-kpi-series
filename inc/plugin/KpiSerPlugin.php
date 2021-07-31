<?php

namespace kpiser;

require_once __DIR__."/../utils/Singleton.php";
require_once __DIR__."/../utils/Template.php";
require_once __DIR__."/../utils/HtmlUtil.php";
require_once __DIR__."/../model/Series.php";
require_once __DIR__."/../controller/AjaxController.php";
require_once __DIR__."/../controller/DashboardController.php";

class KpiSerPlugin extends Singleton {
	private $data;

	protected function __construct() {
		add_action("admin_enqueue_scripts",array($this,"enqueue_scripts"));

		AjaxController::instance();
		DashboardController::instance();

		$this->data=get_file_data(KPISER_PATH."/wp-kpi-series.php",array(
			'Version'=>'Version',
			'TextDomain'=>'Text Domain'
		));
	}

	public function enqueue_scripts() {
		wp_enqueue_script("chartjs",
			"https://cdn.jsdelivr.net/npm/chart.js",
			array(),$this->data["Version"],true);

		wp_enqueue_script("moment",
			"https://cdn.jsdelivr.net/npm/moment@2.27.0",
			array(),$this->data["Version"],true);

		wp_enqueue_script("chartjs-moment",
			"https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@0.1.1",
			array(),$this->data["Version"],true);

		wp_enqueue_script("kpiseries",
			KPISER_URL."/res/wp-kpi-series.js",
			array("chartjs","moment","chartjs-moment","jquery"),$this->data["Version"],true);
	}
}
