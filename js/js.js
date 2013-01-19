$(window).ready(function() {

	$('#graphs').live('click', function() {

		$('#overlay').css('width', $(window).width() + 'px');
		$('#overlay').css('height', $(window).height() + 'px');
		$('#graph').css('width', $(window).width() + 'px');
		$('#graph').css('height', ($(window).height() - 35) + 'px');
		$('#graph').empty();

		$.ajax({
			url : "rpi_heat.php",
			dataType : "json",
			type : "GET",
			data : {
				command : "get_data"
			},
			success : function(newdata) {

				var m = [10, 40, 40, 40];
				// margins
				var w = $(window).width() - m[1] - m[3];
				// width
				var h = $(window).height() - 35 - m[0] - m[2];
				// height

				var format = d3.time.format("%Y-%m-%d %H:%M");

				newdata.forEach(function(d) {

					d.time = format.parse(d.time);
					d.temp = parseFloat(d.temp);
				});

				var mintime = _.min(newdata, function(d) {
					return d.time;
				});
				var maxtime = _.max(newdata, function(d) {
					return d.time
				});

				var mintemp = _.min(newdata, function(d) {
					return d.temp;
				});
				var maxtemp = _.max(newdata, function(d) {
					return d.temp
				});

				var y = d3.scale.linear().domain([mintemp.temp, maxtemp.temp]).range([h, 0]);

				// create a line function that can convert data[] into x and y points
				var line = d3.svg.line()
				// assign the X function to plot our line as we wish
				.x(function(d, i) {
					return x(d.time);
				}).y(function(d) {
					return y(d.temp);
				})
				// Add an SVG element with the desired dimensions and margin.
				var graph = d3.select("#graph").append("svg:svg").attr("width", w + m[1] + m[3]).attr("height", h + m[0] + m[2]).append("svg:g").attr("transform", "translate(" + m[3] + "," + m[0] + ")");

				// create yAxis

				var x = d3.time.scale().domain([mintime.time, maxtime.time]).rangeRound([0, w]);
				var xAxis = d3.svg.axis().scale(x).orient("bottom").ticks(d3.time.hours, 4).tickSubdivide(3).tickFormat(d3.time.format("%b %d %H:%M "));
				// Add the x-axis.1
				graph.append("svg:g").attr("class", "x axis").attr("transform", "translate(0," + h + ")").call(xAxis);

				graph.selectAll('.x .tick').attr('y2', -h);

				// create left yAxis
				var yAxisLeft = d3.svg.axis().scale(y).ticks(10).tickSubdivide(1).orient("left");
				// Add the y-axis to the left
				graph.append("svg:g").attr("class", "y axis").attr("transform", "translate(0,0)").call(yAxisLeft);

				// Add the line by appending an svg:path element with the data line we created above
				// do this AFTER the axes above so that the line is above the tick-lines
				graph.append("svg:path").attr("d", line(newdata));

				$('#overlay').fadeIn();

			}
		});

	});

	$('#close').live('click', function() {
		$('#overlay').fadeOut();
	});

	$.get('rpi_heat.php', {
		command : "read_sensors"
	}, function(data) {

		var n = data.split("|");

		$('.temp').text(n[2]);
		$('.temp2').text(n[3]);

		if (n[1] == 0) {
			$('.state').removeClass('open');
			$('.state').text('Off');
		} else {
			$('.state').addClass('open');
			$('.state').text('On');
		}

	});

	$.get('rpi_heat.php', {
		command : "minutes_today"
	}, function(data) {
		$('.totaltimeon').text(data);
	});

	$('#open').click(function() {
		$.get('rpi_heat.php', {
			command : "turn_on_heating"
		}, function(data) {
		});
	});

	$('#openwater').click(function() {
		$.get('rpi_heat.php', {
			command : "turn_on_water"
		}, function(data) {
		});
	});

	$('#close').click(function() {
		$.get('rpi_heat.php', {
			command : "turn_off_everything"
		}, function(data) {
		});
	});

	var myVar = setInterval(function() {
		temperatureCheck()
	}, 3000);

	function temperatureCheck() {
		$.get('rpi_heat.php', {
			command : "read_sensors"
		}, function(data) {
			var n = data.split("|");

			$('.temp').text(n[2]);
			$('.temp2').text(n[3]);

			if (n[1] == 0) {
				$('.state').removeClass('open');
				$('.state').text('Off');
			} else {
				$('.state').addClass('open');
				$('.state').text('On');
			}
		});
	}
}); 