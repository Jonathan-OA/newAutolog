// Welcome to the RazorFlow Dashbord Quickstart. Simply copy this "dashboard_quickstart"
// to somewhere in your computer/web-server to have a dashboard ready to use.
// This is a great way to get started with RazorFlow with minimal time in setup.
// However, once you're ready to go into deployment consult our documentation on tips for how to 
// maintain the most stable and secure 

StandaloneDashboard(function(db){
	var chart = new ChartComponent();
    chart.setDimensions (12, 4);
    chart.setCaption("A pie chart");
    chart.setLabels (["Jan", "Feb", "Mar"]);
    chart.setPieValues ([10, 14, 13]);
    chart.onItemClick(function(obj) {
        console.log(obj);
    });
    db.addComponent (chart);
});