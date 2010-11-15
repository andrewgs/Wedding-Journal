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