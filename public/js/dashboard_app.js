// Welcome to the RazorFlow Dashbord Quickstart. Simply copy this "dashboard_quickstart"
// to somewhere in your computer/web-server to have a dashboard ready to use.
// This is a great way to get started with RazorFlow with minimal time in setup.
// However, once you're ready to go into deployment consult our documentation on tips for how to 
// maintain the most stable and secure 

StandaloneDashboard(function(db){
	// YOU CAN DELETE THE ENTIRE CONTENTS OF THIS FUNCTION AND CUSTOMIZE
	// AS PER YOUR REQUIREMENT. 
	// These components are simply here to give you a quick introduction of how RazorFlow Works
	//
	var kpi = new KPIComponent ();
	kpi.setDimensions (4, 2);
	kpi.setCaption ("Separado");
	kpi.setValue (42,{
        numberPrefix: "$", 
        valueTextColor: "#ff000d"
    });
	db.addComponent (kpi);
	// Add a chart to the dashboard. This is a simple chart with no customization.
	var chart = new ChartComponent();
	chart.setCaption("Sales");
	chart.setDimensions (6, 6);	
	chart.setLabels (["2013", "2014", "2015"]);
	chart.addSeries ([3151, 1121, 4982]);
	db.addComponent (chart);
});