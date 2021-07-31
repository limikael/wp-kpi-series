<?php

namespace kpiser;

class DashboardController extends Singleton {
	protected function __construct() {
		add_action('wp_dashboard_setup',array($this,'wp_dashboard_setup'));
	}

	public function wp_dashboard_setup() {
		wp_add_dashboard_widget('kpis','KPIs',array($this,'display_widget'));
	}

	public function display_widget() {
		$tpl=new Template(__DIR__."/../tpl/dashboard-widget.tpl.php");
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
}
