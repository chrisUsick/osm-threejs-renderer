'use strict'
// var req = new XMLHttpRequest();
// req.open('GET', 'api.php/center', true);
// req.onreadystatechange = function () {
//   if (req.readyState == 4 && req.status == 200){
//     console.log(req.responseText)
//     var xml = req.responseXML;
//     var output = document.getElementById('output');
//     // output.innerHTML = (new XMLSerializer).serializeToString(xml);
//     var str = 'latitude: ';
//     str += getText(xml.getElementsByTagName('latitude')[0]);
//     str += ' longitude: ';
//     str += getText(xml.getElementsByTagName('longitude')[0]);
//     // output.innerHTML = str;
//   }
// }
// req.send();
function request({method = 'GET', url}) {
  var req = new XMLHttpRequest();
  return new Promise((resolve, reject) => {
    req.open(method, url);
    req.onreadystatechange = () => {
      if (req.readyState == 4 && req.status == 200){
        resolve(req.responseXML);
      } else if (req.readyState == 4){
        reject(req);
      }
    }
    req.send();
  });

}
function getText(elem) {
  return elem.firstChild.nodeValue;
}

// var env = new Environment(document.getElementById('three'));
// env.animate();
(P.coroutine(function* () {
  var center = yield request({url:'api.php/center'});
  console.log(center);
}))();
