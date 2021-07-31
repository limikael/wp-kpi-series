<p>
	<select id="kpi-series-select">
		<?php \kpiser\HtmlUtil::displaySelectOptions($serSelectOptions); ?>
	</select>
	<select id="kpi-month-select">
		<?php \kpiser\HtmlUtil::displaySelectOptions($monthSelectOptions); ?>
	</select>
</p>
<p>
	<canvas class="wp-kpi-series-chart"
			data-series-select="#kpi-series-select"
			data-month-select="#kpi-month-select"></canvas>
</p>
