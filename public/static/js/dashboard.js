/*!
  * ipfs public gateway ui
  *
  */

function bandwidth(){

  const inData = old_bandwidth.map(item => (item.in/1024));
  const outData = old_bandwidth.map(item => (item.out/1024));
  const labels = old_bandwidth.map(item => { return uxdt(item.time)});
  const ctx = document.getElementById('bandwidth_graph').getContext('2d');
  new Chart(ctx, {
            type: 'line', // You can also use 'bar' for bar chart
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'In Data',
                        data: inData,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1,
                        fill: true // Set to true if you want the area under the line filled
                    },
                    {
                        label: 'Out Data',
                        data: outData,
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.1,
                        fill: true // Set to true if you want the area under the line filled
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'In/Out Data Over Time'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: true,
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Time'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Value'
                        },
                        beginAtZero: true // Ensures the Y-axis starts from zero
                    }
                }
            }
        });



}


function unixt(){
  var unixTimestampMs =  Math.floor(Date.now() / 1000);
  return unixTimestampMs;
}

function uxdt(unix_time_stamp){
  const dateObject = new Date(unix_time_stamp*1000);
  return dateObject.toLocaleString();

}

function init_pollers(){
  var bw = setTimeout(bandwidth(),2500);

}

document.addEventListener("DOMContentLoaded", (event) => {
  init_pollers();
});
