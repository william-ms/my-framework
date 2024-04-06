var xhttp = new XMLHttpRequest;

function xmlHttpGet(uri, callback, params = '')
{
  xhttp.onreadystatechange = callback;

  xhttp.open('GET', uri + params, true);
  xhttp.send();
}

function xmlHttpPost(uri, callback, params = '')
{
  xhttp.onreadystatechange = callback;

  xhttp.open('POST', uri, true);
  xhttp.send(params);
}

// function xmlHttpPut()
// {
  
// }

// function xmlHttpDelete()
// {
  
// }

function beforeSend(callback)
{
  if(xhttp.readyState < 4)
  {
    return callback();
  }
}

function success(callback)
{
  if(xhttp.readyState == 4 && xhttp.status == 200)
  {
    return callback();
  }
}

function error(callback)
{
  xhttp.onerror = callback;
}