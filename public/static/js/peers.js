function countryCodeToFlagEmoji(countryCode) {
  // Ensure the country code is uppercase for consistency
  countryCode = String(countryCode).toUpperCase();

  // Check if the country code is valid (two letters)
  if (!/^[A-Z]{2}$/.test(countryCode)) {
    console.warn("Invalid country code provided:", countryCode);
    return ""; // Return an empty string or null for invalid input
  }

  // The Unicode for regional indicator symbols starts at U+1F1E6.
  // 'A' corresponds to U+1F1E6, 'B' to U+1F1E7, and so on.
  // We can calculate the Unicode scalar value for each letter
  // by adding its position in the alphabet to the base.

  const firstChar = countryCode.charCodeAt(0) - 0x41 + 0x1F1E6; // 'A' is 0x41 in ASCII
  const secondChar = countryCode.charCodeAt(1) - 0x41 + 0x1F1E6;

  // Convert the Unicode scalar values to a string (emoji)
  return String.fromCodePoint(firstChar, secondChar);
}
function update_flag(){
  var flag_items = document.getElementsByClassName('cc');
  for(var i = 0;i<=flag_items.length;i=i+1){
    var flag_elem = flag_items[i];
    if(flag_elem){
      var cc = flag_items[i].getAttribute("data-cc");
      flag_items[i].innerHTML = countryCodeToFlagEmoji(cc);  
    }else{

    }


  }

}
update_flag();
