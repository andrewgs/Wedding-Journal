$('.MultiFile').MultiFile({ 
	accept:'jpg|gif|png|',max:5,STRING:{ 
	remove		:'<img src="<?=$baseurl;?>images/cancel.png" height="16" width="16" alt="cancel"/>',
	file		:'$file', 
	selected	:'Выбраны: $file', 
	denied		:'Неверный тип файла: $ext!', 
	duplicate	:'Этот файл уже выбран:\n$file!' 
	},
	afterFileAppend: function(element, value, master_element){
		var fshgt = $('fieldset.multiupload').height();
		$('fieldset.multiupload').css({'height':fshgt+20});
		var topvalue = $('#closemultiupload').css("top").substring(0,$('#closemultiupload').css("top").indexOf("px"));
		$('#closemultiupload').css({'top':Number(topvalue)+20});
	},
	afterFileRemove: function(element, value, master_element){
		var fshgt = $('fieldset.multiupload').height();
		$('fieldset.multiupload').css({'height':fshgt-20});
		var topvalue = $('#closemultiupload').css("top").substring(0,$('#closemultiupload').css("top").indexOf("px"));
		$('#closemultiupload').css({'top':Number(topvalue)-20});
	}
});		  
$("#loading").ajaxStart(function(){$(this).show();}).ajaxComplete(function(){$(this).hide();});
$('#uploadForm').ajaxForm({
	beforeSubmit: function(a,f,o){
		o.dataType = "html";
		$('#uploadOutput').html('Загрузка...');
		var fshgt = $('fieldset.multiupload').height();
		$('fieldset.multiupload').css({'height':fshgt+20});
	},
	success: function(data){
		$('#uploadOutput').empty();
		var fshgt = $('fieldset.multiupload').height();
		$('fieldset.multiupload').css({'height':fshgt-20});
	}
});
$(function(){
		$("#singleupload").click(function(){
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		$("fieldset.singleuploadform").slideDown("slow");
		$("#showuploadif").hide(1000);
		$('#ssuwindow').css({'width':maskWidth,'height':maskHeight});
		$('#ssuwindow').fadeIn(2000);
	});
	$("#closesingleupload").click(function(){
		$('#ssuwindow').fadeOut("slow",function(){$('#ssuwindow').hide();});
		$("fieldset.singleuploadform").hide(1000);
		$("#showuploadif").show(2000);
	});
	$("#multiupload").click(function(){
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		$("fieldset.multiupload").slideDown("slow");
		$("#showuploadif").hide(1000);
		$('#smuwindow').css({'width':maskWidth,'height':maskHeight});
		$('#smuwindow').fadeIn(2000);
	});
	$("#closemultiupload").click(function(){
		$('#smuwindow').fadeOut("slow",function(){$('#smuwindow').hide();});
		$("fieldset.multiupload").hide(1000);
		$("#showuploadif").show(2000);
	}); 
});