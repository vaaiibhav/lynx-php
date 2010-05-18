/** global request variable -- holds the xmlHttpRequest object **/
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
  
  request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

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
  if(window.sidebar)
    window.sidebar.addPanel(title, url, "");
  else
    window.external.AddFavorite(url, title)
}