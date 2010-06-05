/** global request variable -- holds the XMLHttpRequest object **/
var request = null;

/** function to create an XMLHttpRequest 
 * object and assign it to the request variable **/
function createRequest(){
  try {
    request = new XMLHttpRequest();
  } catch (trymicrosoft){
    try {
      request = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (othermicrosoft) {
      try {
        request = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (failed) {
        request = null;
      }
    }
  }

  if(request == null){
    alert("Error creating request object.");
  }

}

/** function to asynchronously get a page **/
function fetchURL(url){
	if(request == null)
		createRequest();
	request.open('GET', url, false);
	request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	request.onreadystatechange = returnResponse;
	request.send(null);
}

function returnResponse(){
	if(request.readyState == 4){
	    if(request.status == 200){
	      // expect JSON return
	      //request.responseXML = eval('(' + request.responseText + ')');
	      // expect HTML return
	      return request.responseText;
	    } else {
	      alert("Error receiving value. HTTP Code " + request.status);
	    }
	  }
}

function getURL(url){
	fetchURL('/index.php/default/index/ajax');
	return returnResponse();
}

/** function to easily get elements by id or name 
 * passing a name will return either the top level named 
 * item or an array of items with the name, whichever is found **/
function $(id){
	var e = document.getElementById(id);
	if(e != undefined){
		return e;
	} else {
		e = document.getElementsByName(id);
		if(e != undefined){
			if(e.length == 1)
				return e[0];
			else
				return e;
		} else {
			alert('Can not locate ' + id);
		}
	}
		
}

/** function to easily getElementsByName **/
function $$(name){
	e = document.getElementsByName(name);
	if(e != undefined)
		return e
	return false;
}

/** like php print_r() **/
function print_r(theObj){
  if(theObj.constructor == Array ||
     theObj.constructor == Object){
    document.write("<ul>")
    for(var p in theObj){
      if(theObj[p].constructor == Array||
         theObj[p].constructor == Object){
    	  document.write("<li>["+p+"] => "+typeof(theObj)+"</li>");
        document.write("<ul>")
        print_r(theObj[p]);
        document.write("</ul>")
      } else {
    	  document.write("<li>["+p+"] => "+theObj[p]+"</li>");
      }
    }
    document.write("</ul>")
  }
}


/** function to display a JS confirm box displaying the value 
 * of the msg variable and redirecting to target on true **/
function checkConfirm(msg, target){
  if(confirm(msg))
    window.location.href = target;
  else
    return false;
}

/** function to add a bookmark to the browser **/
function addBookmark(title, url){
  if(window.sidebar) // firefox
    window.sidebar.addPanel(title, url, "");
  else // IE
    window.external.AddFavorite(url, title)
}