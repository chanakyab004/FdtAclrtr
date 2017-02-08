var ChartSet = function ChartSet() {
    var self = this;
    self.init = function(){
		 // Load the Visualization API and the piechart package.
	    google.charts.load('current', {'packages':['corechart']});

	    // Set a callback to run when the Google Visualization API is loaded.
	    google.charts.setOnLoadCallback(self.drawChart);
	};
	self.init();

    self.drawChart = function(container, dataLocation, startDate, endDate, chartType) {
      	var jsonData = $.ajax({
          	url: dataLocation,
          	type: 'POST',
          	dataType: "json",
          	data: {
          		dateFrom:startDate,
          		dateTo: endDate
         	}
          	}).done(function(jsonData) {
          
	      		// Create our data table out of JSON data loaded from server.
	      		var data = new google.visualization.DataTable(jsonData.data);

		       	var options = {
		          title: jsonData.title
		        };

		      	// Instantiate and draw our chart, passing in some options.
		      	var chart = new google.visualization.ColumnChart(container);
		      	//chart.draw(data);
		      	chart.draw(data, options);

		  	}).fail(function() {
			  	google.visualization.errors.addError(chartDiv, 
			    "Failed to load data for the chart.");
			});
    }

}