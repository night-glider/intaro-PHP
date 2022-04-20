let metroForm = document.getElementById("metro-form");
let metroIcon = document.getElementById("metro-icon");
let metroSendButton = document.getElementById("send-button");

//Обработка нажатия на значок метро
metroIcon.onclick = function() { 
	//переключаем видимость формы
	if (metroForm.style.visibility == "hidden" )
		metroForm.style.visibility = "visible";
	else
		metroForm.style.visibility = "hidden";
}

//обработка нажатия на кнопку
metroSendButton.onclick = function() {
	let url = "get_info.php?place=" + document.getElementById("place").value;

	fetch(url)
    .then((response) => response.text())
    .then((result) => {
    	//alert(result);
    	document.getElementById("metro-result-message").innerHTML = result;
    })
}