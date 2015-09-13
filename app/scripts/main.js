var req = new XMLHttpRequest();
req.open('GET', 'center.php', true);
req.onreadystatechange = function () {
  if (req.readyState == 4 && req.status == 200){
    console.log(req.responseText)
    var xml = req.responseXML;
    var output = document.getElementById('output');
    // output.innerHTML = (new XMLSerializer).serializeToString(xml);
    var str = 'latitude: ';
    str += getText(xml.getElementsByTagName('latitude')[0]);
    str += ' longitude: ';
    str += getText(xml.getElementsByTagName('longitude')[0]);
    output.innerHTML = str;
  }
}
req.send();

function getText(elem) {
  return elem.firstChild.nodeValue;
}

console.log('foo');
