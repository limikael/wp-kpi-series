<?php

namespace kpiser;

require_once __DIR__."/../utils/Singleton.php";

class AjaxHandler extends Singleton {
	protected function __construct($action) {
		add_action("wp_ajax_$action",array($this,"dispatch"));
		add_action("wp_ajax_nopriv_$action",array($this,"dispatch"));
	}

	/**
	 * Handle call.
	 */
	public function dispatch() {
		$request=array();
		foreach ($_REQUEST as $k=>$v)
			$request[$k]=stripslashes($v);

		$method=$request["call"];

		try {
			if (!method_exists($this, $method))
				throw new \Exception("Unknown method: ".$method);

			$res=$this->$method($request);
		}

		catch (\Exception $e) {
			echo json_encode(array(
				"ok"=>0,
				"message"=>$e->getMessage()
			),JSON_PRETTY_PRINT)."\n";

			wp_die('','',array("response"=>500));
			exit;
		}

		$res["ok"]=1;
		echo json_encode($res,JSON_PRETTY_PRINT)."\n";
		wp_die();
	}
}