
function formWind()
{
	var newWind = window.close();
    newWind = window.open('', 'newwin', 'width=640, height=480, top=100, left=450, status=no, location=no, toolbar=no, menubar=no');
	newWind.document.write('<center>Записати до БД дані<br>');
    newWind.document.write('Відмітьте для запису<input type="checkbox" name=" ">');

}

 