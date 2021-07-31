<div class="wrap">
	<div class="welcome-panel" style="max-width: 40rem">
		<div class="welcome-panel-content">
			<h2>KPIs</h2>
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
		</div>
	</div>
</div>