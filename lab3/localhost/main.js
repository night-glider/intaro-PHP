let feedbackForm = document.getElementById("feedback-form");
let feedbackIcon = document.getElementById("feedback-icon");
let feedbackSendButton = document.getElementById("feedback-send-button");
let feedbackErrorMessage = document.getElementById("feedback-error-message");
let feedbackFormCompleted = document.getElementById("feedback-form-completed");

feedbackFormCompleted.style.visibility = "hidden"; //прячем сообщение об отправке заявки

//Обработка нажатия на значок обратной связи
feedbackIcon.onclick = function() { 
	//переключаем видимость формы отправки обратной связи
	if (feedbackForm.style.visibility == "hidden" )
		feedbackForm.style.visibility = "visible";
	else
		feedbackForm.style.visibility = "hidden";

	feedbackFormCompleted.style.visibility = "hidden"; //прячем сообщение об отправке заявки в любом случае.
}

//обработка нажатия на кнопку отправки заявки
feedbackSendButton.onclick = function() {
	if ( validate() )
	{
		feedbackForm.style.visibility = "hidden";
		feedbackFormCompleted.style.visibility = "visible";

		let url = "send_entry.php?FIO=" + document.getElementById("FIO").value;
		url += "&email=" + document.getElementById("email").value;
		url += "&phone=" + document.getElementById("phone").value;
		url += "&comment=" + document.getElementById("comment").value;

		fetch(url)
	    .then((response) => response.text())
	    .then((result) => {
	    	//alert(result);
	    	document.getElementById("feedback-form-completed-body").innerHTML = result;
	    })
	}
}

//функция валидации формы
//В случае ошибки сразу выводит сообщение об ошибке
//Возвращает результат валидации (true - все поля валидны, в ином случае false)
function validate()
{
	feedbackErrorMessage.innerHTML = ""; //очищаем сообщение об ошибке
	var fio = document.getElementById("FIO"); 
	var email = document.getElementById("email");
	var phone = document.getElementById("phone");
	var fio_reg = /[А-я]{3,25} [А-я]{3,25} [А-я]{3,25}/; //regex для проверки ФИО
	var email_reg = /[a-zA-Z._]{3,25}@[a-z]{3,20}\.[a-z]{2,3}/; //regex для проверки Email
	var phone_reg = /\+?[0-9]{11}/; //regex для проверки телефона
	//последовательно проверяем все поля на валидность.
	//в случае ошибки добавляем пояснение в поле для ошибок
	if ( !fio_reg.test( fio.value ))
		feedbackErrorMessage.innerHTML += "ФИО должно быть в формате <Пупкин Василий Васильевич><br />";
	if ( !email_reg.test( email.value ))
		feedbackErrorMessage.innerHTML += "E-mail должен быть в формате test@gmail.com<br />";
	if ( !phone_reg.test( phone.value ))
		feedbackErrorMessage.innerHTML += "Телефон должен быть в формате 89205109999 или +79205109999<br />";

	//возвращаем результат валидации
	return fio_reg.test( fio.value ) && email_reg.test( email.value ) && phone_reg.test( phone.value );
	
}