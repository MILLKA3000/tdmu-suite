$('.DEPARTMENT').change(function() {window.location.href='vidomist_old.php?DEPARTMENT='+ encodeURIComponent($('select[name=\'DEPARTMENT\']').val());});
$('.SPECIALITY').change(function() {window.location.href='vidomist_old.php?DEPARTMENT='+ encodeURIComponent($('select[name=\'DEPARTMENT\']').val())+'&SPECIALITY='+ encodeURIComponent($('select[name=\'SPECIALITY\']').val());});
$('.DISCIPLINE').change(function() {window.location.href='vidomist_old.php?DEPARTMENT='+ encodeURIComponent($('select[name=\'DEPARTMENT\']').val())+'&SPECIALITY='+ encodeURIComponent($('select[name=\'SPECIALITY\']').val())+'&DISCIPLINE='+ encodeURIComponent($('select[name=\'DISCIPLINE\']').val());});
$('.semester').change(function() {window.location.href='vidomist.php?student='+id_styd+'&semester='+ encodeURIComponent($('select[name=\'semester\']').val());});
var modul='';
function vido(){
window.open('one_vidomist.php?student='+id_styd+'&semester='+semester+'&date='+encodeURIComponent($('input[name=\'date\']').val())+'&ocinka='+encodeURIComponent($('input[name=\'ocinka\']').val())+'&modul='+modul,'…','width=800,height=600,toolbar=yes'); return false


}
$(function(){
			window.prettyPrint && prettyPrint();
			$('#dp1').datepicker({
				format: 'dd.mm.yyyy',
				weekStart: 1
			});
			var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#dpd1').datepicker({
          onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
          }
          checkin.hide();
          $('#dpd2')[0].focus();
        }).data('datepicker');
        var checkout = $('#dpd2').datepicker({
          onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');
		});
		
		

		$('.ser').hide();
		$('.ser').show("slow");
		var mas;
		for (var i in mas){
		name='id['+mas[i]+']';
		$('input[name="' + name + '"]').each(function(){
            $(this).attr('checked', true);
        });
		$('tr').each(function(){
					if($(this).attr('name') == name){
					$(this).attr('bgcolor','#99CCFF');
					}
					});
		}
	$('.id_vid').click(function(event){

		var val = $(this).attr('value');
		$('tr').each(function(){
			if(($(this).attr('name') != val) && ($(this).attr('class')=='id_vid_tr')){
            $(this).css('display', 'none');}
        });
		window.location.href='vidomist.php?student='+val;
	});	
	$('.mod').click(function(event){
		var val = $(this).attr('value');
				modul=val;
		if ($(this).is(":checked")){
		
		$('tr').each(function(){
			if(($(this).attr('name') != val) && ($(this).attr('class')=='id_mod')){
            $(this).css('display', 'none');
			}
        });
		$('#over').css('height', '100px');
		$('.vidomist').css('display', '');
		}else{
		
		$('tr').each(function(){$(this).css('display', '');});
		$('#over').css('height', '300px');
		$('.vidomist').css('display', 'none');}
		//window.location.href='vidomist.php?student='+val;
	});	
		
    $('.id').click(function(event){
        var name = $(this).attr('name');
		if ($(this).is(":checked")){	
       $('input[name="' + name + '"]').each(function(){
            $(this).attr('checked', true);
        });
			$('tr').each(function(){
					if($(this).attr('name') == name){
					$(this).attr('bgcolor','#99CCFF');
					
					}
					});
		}else{
		$('input[name="' + name + '"]').each(function(){
            $(this).removeAttr('checked');
        });
		$('tr').each(function(){
					if($(this).attr('name') == name){
					$(this).attr('bgcolor','white');
					}
					});
		}});
		
    function do_this(){
	var button = document.getElementById('toggle');
	if (button.value == 'S'){
	$('input[class=id]').each(function(){
            $(this).attr('checked', true);
        });
		$('tr [class=id2]').each(function(){					
					$(this).attr('bgcolor','#99CCFF');
					});
					button.value = 'D';
		}else{
		$('input[class=id]').each(function(){
            $(this).removeAttr('checked');
        });
		$('tr [class=id2]').each(function(){
					$(this).attr('bgcolor','white');
					});
					button.value = 'S';
		}
    }
	
	
$('.t').click(function() { 
if ($(this).attr('act')=='Y'){
$('div[tabl=d]').each(function(){
            $(this).slideUp();
			$('.t').attr('act','Y');
			$('.t').attr('src','images/down.gif');
        });
$('#'+$(this).attr('name')).slideDown(250);
$(this).attr('act','N');
$(this).attr('src','images/up.gif');
} else {
$('#'+$(this).attr('name')).slideUp();
$(this).attr('act','Y');
$(this).attr('src','images/down.gif');
}

});	



$('#active_d').click(function() { 
if ($(this).attr('act')=='N'){
$('#disciplin').slideUp();
$(this).attr('act','Y');
$(this).attr('src','http://market.auto.ria.ua/img/plus.gif');
} else {
$('#disciplin').slideDown();
$(this).attr('act','N');
$(this).attr('src','http://market.auto.ria.ua/img/minus.gif');
}

});