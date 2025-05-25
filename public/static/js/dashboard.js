/*!
  * ipfs public gateway ui
  *
  */

function bandwidth(){
  console.log(old_bandwidth);


}


function unixt(){
  var unixTimestampMs =  Math.floor(Date.now() / 1000);
  return unixTimestampMs;
}

function uxdt(unix_time_stamp){
  const dateObject = new Date(unix_time_stamp*1000);
  console.log(dateObject)  ;

}

function init_pollers(){
  var bw = setTimeout(bandwidth(),2500);

}

document.addEventListener("DOMContentLoaded", (event) => {
  init_pollers();
});
