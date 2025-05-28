/*!
  * ipfs public gateway ui
  *
  */

  let inData = [0];
  let outData = [0];
  let labels =[""];
  let bw_chart;
function bandwidth(){

   inData = old_bandwidth.map(item => (-parseFloat(item.out/1048576)));
   outData = old_bandwidth.map(item => (item.in/1048576));
   labels = old_bandwidth.map(item => { return uxdt(item.time)});
  const ctx = document.getElementById('bandwidth_graph').getContext('2d');
  bw_chart = new Chart(ctx, {
            type: 'line', // You can also use 'bar' for bar chart
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'In Data',
                        data: inData,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.8,
                        fill: true // Set to true if you want the area under the line filled
                    },
                    {
                        label: 'Out Data',
                        data: outData,
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.8,
                        fill: true // Set to true if you want the area under the line filled
                    }
                ]
            },
            options: {
                responsive: true,
                stacked: false,
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
                            text: 'In MB'
                        },
                        beginAtZero: true // Ensures the Y-axis starts from zero
                    }
                }
            }
        });
}

function update_bw(){
  $.getJSON('api/bw',function(data){
    inData[inData.length - 1]=-parseFloat(data.TotalOut/1048576);
    outData[outData.length - 1]=data.TotalIn/1048576;
    bw_chart.update();
  })
}

function getFlagEmoji(countryCode) {
  const codePoints = countryCode
    .toUpperCase()
    .split('')
    .map(char =>  127397 + char.charCodeAt());
  return String.fromCodePoint(...codePoints);
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
  setInterval(update_bw,10000);

}




document.addEventListener("DOMContentLoaded", (event) => {
  init_pollers();
  bandwidth();
});
