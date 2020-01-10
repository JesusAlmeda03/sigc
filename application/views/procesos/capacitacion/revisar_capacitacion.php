<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">			
			  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
			  google.setOnLoadCallback(drawChart);			  
			  function drawChart() {		
			  var data = new google.visualization.DataTable();
			  data.addColumn("string", "Habilidad/Aptitud");
			  data.addColumn("number", "Avance");
			  data.addRows(['.$mediciones.']);
			  var options = {
				  width: 650,
				  height: 300,
				  colors: ["#CC0000"],
				  fontSize: "12",
				  fontName: "Tahoma",
				  legend: "none",
				  vAxis: { title: "Porcentaje", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
				  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "maximized",
						  },
				  chartArea: { top: 30, left: 100, width: 590, height: 200 },
				  tooltipTextStyle: { fontSize: "16" },
			  };
			  
			  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
			  formatter.format(data, 1); // Apply formatter to second column
  
			  var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
			  chart.draw(data, options);
			}
			</script>
            <div id="chart_div"></div>
		';