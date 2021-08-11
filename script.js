$(document).ready(function() {

//загрузка файлов в форму
  let inputs = document.querySelectorAll('.input__file');
  Array.prototype.forEach.call(inputs, function (input) {
    let label = input.nextElementSibling,
      labelVal = label.querySelector('.input__file-button-text').innerText;

    input.addEventListener('change', function (e) {
      let countFiles = '';
      if (this.files && this.files.length >= 1)
        countFiles = this.files.length;

      if (countFiles)
        label.querySelector('.input__file-button-text').innerText = 'Выбрано файлов: ' + countFiles;
      else
        label.querySelector('.input__file-button-text').innerText = labelVal;
    });
  });

  //валидация
  jQuery.validator.addMethod("checkMask", function(value, element) {
	return /\+\d{1}\(\d{3}\)\d{3}-\d{4}/g.test(value);
});
$('#fileinfo').validate({
	rules: {
		email: {
			email: true
		},
		phone: {
			checkMask: true
		}
	},
	messages: {
		email: {
			email: "Введите корректно email"
		},
		phone: {
			checkMask: "Введите полный номер телефона"
		}
	}
});
$('.phone').mask("+7(999)999-9999", {
	autoclear: false
});

});



//отправка данных из формы
function post_form() {
	var fd = new FormData(document.getElementById("fileinfo"));
  $.each($("#project_foto")[0].files,function(key, input){
    fd.append('file[]', input);
  });

	$.ajax({
		url: "create.php",
		type: "POST",
		data: fd,
		processData: false,
		contentType: false
	}).done(function(data) {
    $("#result_form").fadeIn(300);
    $("#result_form").text('Данные отправлены').delay(2500).fadeOut(300);
    $('#fileinfo').trigger('reset');
		console.log(data);
	});
	return false;
}
