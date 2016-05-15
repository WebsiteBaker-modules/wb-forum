/**
 *	0.5.9
 */
function delete_thread(aRef, aId, aTitle, aClass) {
	if(confirm("Are you sure you want to delete: "+aTitle+"?")) {
		var f = document.getElementById(aRef);
		if(f){
			f.elements['postid'].value = aId;
			f.elements['class'].value = aClass;
			f.submit();
		}
		return true;
	} else {
		return false;
	}
}

function edit_post(aRef, aId, aTitle, aClass, aAction) {

	var f = document.getElementById(aRef);
	if(f){
		f.elements['postid'].value = aId;
		f.elements['class'].value = aClass;
		f.action = aAction;
		f.submit();
	}
	return true;
		
}