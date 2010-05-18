var request = null;

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

function checkConfirm(msg, target){
  if(confirm(msg))
    window.location.href = target;
  else
    return false;
}

function addBookmark(title, url){
  if(window.sidebar)
    window.sidebar.addPanel(title, url, "");
  else
    window.external.AddFavorite(url, title)
}