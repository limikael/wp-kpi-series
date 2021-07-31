(function($) {
	function daysInMonth (year, month) {
		return new Date(year, month, 0).getDate();
	}

	function loadData(el) {
		let chart=el.chart;

		let data={
			action: "kpi-series",
			call: "getSeriesData",
			series: $(el.dataset.seriesSelect).val(),
			month: $(el.dataset.monthSelect).val()
		};

		$.ajax({
			type: "GET",
			dataType: "json",
			url: ajaxurl,
			data: data,
			success: function(res) {
				chart.data.datasets[0].data=res.data;
				chart.options.scales.x.min=res.xMin;
				chart.options.scales.x.max=res.xMax;
				chart.update();
			},
			error: function(e) {
				console.log(e);
			}
		});
	}

	for (let el of document.getElementsByClassName("wp-kpi-series-chart")) {
		let chart = new Chart(el, {
			type: 'line',
			color: "blue",
			data: {
				datasets: [{
					backgroundColor: "#2271B1",
					borderColor: "#2271B1"
				}]
			},
			options: {
				aspectRatio: 2,
				animation: {
					duration: 0
				},
				plugins: {
					legend: {
						display: false
					}
				},
				scales: {
					y: {
						beginAtZero: true
					},
					x: {
						min: "2021-07-01",
						max: "2021-07-31",
						type: "time"
					}
				}
			}
		});

		el.chart=chart;

		function load() {
			loadData(el);
		}

		load();
		$(el.dataset.seriesSelect).change(load);
		$(el.dataset.monthSelect).change(load);
	}
})(jQuery);