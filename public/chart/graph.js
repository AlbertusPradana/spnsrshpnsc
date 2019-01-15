var t1 = document.getElementById('jogjaindah').value;
var t2 = document.getElementById('indahjogja').value;
var t3 = document.getElementById('jogjataman').value;

var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
// The type of chart we want to create
type: 'doughnut',

// The data for our dataset
data: {
	labels: ["Taman Jogja Indah", "Taman Indah Jogya","Jogja Taman Indah"],
	datasets: [{
		label: "Data survey nama taman kota yang akan dibangun oleh pemkot yogyakarta",
		backgroundColor: ['green','cyan','gold'],
		borderColor: ['green','cyan','gold'],
		data: [t1, t2, t3],
	}]
},

// Configuration options go here
options: {}
});