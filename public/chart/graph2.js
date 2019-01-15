var t1 = document.getElementById('q1').value;
var t2 = document.getElementById('q2').value;
var t3 = document.getElementById('q3').value;
var t4 = document.getElementById('q4').value;

var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
// The type of chart we want to create
type: 'doughnut',

// The data for our dataset
data: {
	labels: ["1 Nilai", "2 Nilai","3 Nilai","4 Nilai"],
	datasets: [{
		label: "Data survey nama taman kota yang akan dibangun oleh pemkot yogyakarta",
		backgroundColor: ['green','cyan','gold','pink'],
		borderColor: ['green','cyan','gold','pink'],
		data: [t1, t2, t3, t4],
	}]
},

// Configuration options go here
options: {}
});