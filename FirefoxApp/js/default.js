cities = [];

$(document).ready(function(){
	//input areas
	document.querySelector('#btn-partidos').addEventListener ('click', function () {
	  document.querySelector('#partidos').className = 'current';
	  document.querySelector('[data-position="current"]').className = 'left';
	});
	document.querySelector('#btn-partidos-back').addEventListener ('click', function () {
	  document.querySelector('#partidos').className = 'right';
	  document.querySelector('[data-position="current"]').className = 'current';
	});

	$.ajax({
		url: 'http://mauriciogiordano.com/deolhonomandato/api/public/city/all',
		type: 'GET',
		success: function(data) {
			cities = data.Data;
			var options = '';
			var city;

			for(var i = 0; i < cities.length; i++) {
				city = cities[i];
				options += '<option value="'+city.id+'" arr-pos="'+i+'">'+city.name+'</option>';
			}

			$("#state-selector select").html(options);
			
			if(cities.length >= 1) {
				selectCity(0,0);
				selectSector(0, 1);
			}
		},
		error: function() {
			
		}
	});

	$("#state-selector select").bind("change", function(e) {
		selectCity($(":selected", e.currentTarget).attr("arr-pos"), 0);
	});

	$("#sector-selector select").bind("change", function() {
		var curr = $("#politician-details").attr("data-current");

		selectSector($("#state-selector select option:selected").attr("arr-pos"), $("#sector-selector select option:selected").val(), curr);
	});

	$("#politicianBefore").click(function() {
		var curr = $("#politician-details").attr("data-current");
		curr++;

		if(!cities[$("#state-selector select option:selected").attr("arr-pos")].politicians[curr])
			return false;
		
		$("#politician-details").attr("data-current",curr);

		selectSector($("#state-selector select option:selected").attr("arr-pos"), $("#sector-selector select option:selected").val(), curr);
	});

	$("#politicianAfter").click(function() {
		var curr = $("#politician-details").attr("data-current");
		curr--;

		if(!cities[$("#state-selector select option:selected").attr("arr-pos")].politicians[curr])
			return false;

		$("#politician-details").attr("data-current",curr);

		selectSector($("#state-selector select option:selected").attr("arr-pos"), $("#sector-selector select option:selected").val(), curr);
	});


	plotAll = function(graphData, tick)
	{

		//console.log(graphData);
		// Lines Graph #############################################
		$.plot($('#graph-lines'), graphData, {
			series: {
				points: {
					show: true,
					radius: 5
				},
				lines: {
					show: true
				},
				shadowSize: 0
			},
			grid: {
				color: '#646464',
				borderColor: 'transparent',
				borderWidth: 20,
				hoverable: true
			},
			xaxis: {
				tickColor: 'transparent',
				tickDecimals: 0
			},
			yaxis: {
				tickSize: tick
			}
		});

		// Bars Graph ##############################################
		$.plot($('#graph-bars'), graphData, {
			series: {
				bars: {
					show: true,
					barWidth: .9,
					align: 'center'
				},
				shadowSize: 0
			},
			grid: {
				color: '#646464',
				borderColor: 'transparent',
				borderWidth: 20,
				hoverable: true
			},
			xaxis: {
				tickColor: 'transparent',
				tickDecimals: 2
			},
			yaxis: {
				tickSize: 1000
			}
		});

		// Graph Toggle ############################################
		$('#graph-bars').hide();

		$('#lines').on('click', function (e) {
			$('#bars').removeClass('active');
			$('#graph-bars').fadeOut();
			$(this).addClass('active');
			$('#graph-lines').fadeIn();
			e.preventDefault();
		});

		$('#bars').on('click', function (e) {
			$('#lines').removeClass('active');
			$('#graph-lines').fadeOut();
			$(this).addClass('active');
			$('#graph-bars').fadeIn().removeClass('hidden');
			e.preventDefault();
		});
	}

	// Tooltip #################################################
	function showTooltip(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css({
			top: y - 16,
			left: x + 20
		}).appendTo('body').fadeIn();
	}

	var previousPoint = null;

	$('#graph-lines, #graph-bars').bind('plothover', function (event, pos, item) {
		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;
				$('#tooltip').remove();
				var x = item.datapoint[0],
					y = item.datapoint[1];
					showTooltip(item.pageX, item.pageY, y + ' visitors at ' + x + '.00h');
			}
		} else {
			$('#tooltip').remove();
			previousPoint = null;
		}
	});
});

function selectCity(arrPos, pol) {
	if(!cities)	return false;

	var city = cities[arrPos];
	if(!city.politicians) city.politicians = new Array(new Object());

	$("#state-selector .title").text(city.name);
	//$("#politician-details .role").text(city.politicians[0].role);

	$("#politician-details").attr("data-current",pol);
	$("#politician-details .name").text(city.politicians[pol].name);
	$("#politician-details .period").text(city.politicians[pol].start + ' - ' + city.politicians[pol].end);
	$("#politician-details .party").text(city.politicians[pol].party.name);
	$("#politician-details .avatar").attr("src", city.politicians[pol].avatar);
	$("#map-canvas").css("background-image", "url(https://maps.googleapis.com/maps/api/staticmap?center="+encodeURI(city.name)+",%20Brasil&zoom=13&size=500x130&sensor=false&key=AIzaSyA02NsF5KhqHpELYODnTKQzN4tT8Bk6nOU)");

	selectSector(arrPos,1,0);
}

function selectSector(arrPos, typeFor, currPol) {
	if(!cities)	return false;

	var dataFrom;

	arrPos = parseInt(arrPos);
	currPol = parseInt(currPol);

	$("#politician-details .name").text(cities[arrPos].politicians[currPol].name);
	$("#politician-details .period").text(cities[arrPos].politicians[currPol].start + ' - ' + cities[arrPos].politicians[currPol].end);
	$("#politician-details .party").text(cities[arrPos].politicians[currPol].party.name);
	$("#politician-details .avatar").attr("src", cities[arrPos].politicians[currPol].avatar);

	switch(parseInt(typeFor))
	{
		case 1:
			dataFrom = cities[arrPos].educations;
			$("#sector-selector .title").html("Educação");
			$("#sector-legend li:first-child").html(cities[arrPos].educations[0].name+" <em>"+cities[arrPos].educations[0].description+"</em> (% porcentagem)");
			$("#sector-legend li:last-child").html(cities[arrPos].educations[1].name+" <em>"+cities[arrPos].educations[1].description+"</em> (% porcentagem)");
			break;
		case 2:
			dataFrom = cities[arrPos].securities;
			$("#sector-selector .title").html("Segurança");
			$("#sector-legend li:first-child").html(cities[arrPos].securities[0].name+" <em>"+cities[arrPos].securities[0].description+"</em>");
			$("#sector-legend li:last-child").html(cities[arrPos].securities[1].name+" <em>"+cities[arrPos].securities[1].description+"</em>");
			break;
		case 3:
			dataFrom = cities[arrPos].transports;
			$("#sector-selector .title").html("Transporte");
			$("#sector-legend li:first-child").html(cities[arrPos].transports[0].name+" <em>"+cities[arrPos].transports[0].description+"</em>");
			$("#sector-legend li:last-child").html(cities[arrPos].transports[1].name+" <em>"+cities[arrPos].transports[1].description+"</em>");
			break;
	}

	var valTo = dataFrom[0].data[0].percentage;
	var dif = 0;

	var min = 0 + currPol*4;
	var max = 3 + currPol*4;

	if(currPol > 0)
	{
		min--;
		max--;
	}

	for(var i=0; i<2; i++)
	{
		for(var j=min; j<max; j++)
		{
			if((valTo - dataFrom[i].data[j].percentage)*
				(valTo - dataFrom[i].data[j].percentage) >
				dif*dif)
			{
				dif = valTo - dataFrom[i].data[j].percentage;
				valTo = dataFrom[i].data[j].percentage;
			}
		}
	}

	if(dif < 0) dif *= (-1);

	// Graph Data ##############################################
	var graph = [{
			// Returning Visits
			data: [ [2009 - min, dataFrom[0].data[max].percentage], [2010 - min, dataFrom[0].data[max-1].percentage], [2011 - min, dataFrom[0].data[max-2].percentage], [2012 - min, dataFrom[0].data[max-3].percentage]],
			color: '#77b7c5',
			points: { radius: 4, fillColor: '#77b7c5' }
		},{
			// Returning Visits
			data: [ [2009 - min, dataFrom[1].data[max].percentage], [2010 - min, dataFrom[1].data[max-1].percentage], [2011 - min, dataFrom[1].data[max-2].percentage], [2012 - min, dataFrom[1].data[max-3].percentage]],
			color: '#646464',
			points: { radius: 4, fillColor: '#646464' }
		}
	];

	plotAll(graph, dif/4);
}