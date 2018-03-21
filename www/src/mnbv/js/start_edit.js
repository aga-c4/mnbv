// JavaScript Document
function initEditor2(edittext1) {
	if (document.all) {
		var editor = frames[editorFr].document;
		editor.open();
		editor.write(edittext1);
		editor.close();
		editor.designMode = "On";
	} else {
		document.getElementById("editorFr").contentDocument.designMode = "on";
		var editor = document.getElementById("editorFr").contentWindow.document;
		editor.open();
		editor.write(edittext1);
		editor.close();
	}
}
