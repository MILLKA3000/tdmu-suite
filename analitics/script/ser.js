$('.DEPARTMENT').change(function() {window.location.href='ser.php?DEPARTMENT='+ encodeURIComponent($('select[name=\'DEPARTMENT\']').val());});
$('.SPECIALITY').change(function() {window.location.href='ser.php?DEPARTMENT='+ encodeURIComponent($('select[name=\'DEPARTMENT\']').val())+'&SPECIALITY='+ encodeURIComponent($('select[name=\'SPECIALITY\']').val());});
$('.DISCIPLINE').change(function() {window.location.href='ser.php?DEPARTMENT='+ encodeURIComponent($('select[name=\'DEPARTMENT\']').val())+'&SPECIALITY='+ encodeURIComponent($('select[name=\'SPECIALITY\']').val())+'&DISCIPLINE='+ encodeURIComponent($('select[name=\'DISCIPLINE\']').val());});
		$('.ser').hide();
		$('.ser').show("slow");
		var mas;
		var year;
		/*for (var i in mas){
			for(var j in year){}
				for(var o in year[j]){
		name='id['+mas[i]+']['+year[j][0]+']['+jear[j][o]+']';
		$('input[name="' + name + '"]').each(function(){
            $(this).attr('checked', true);
        });
		$('tr').each(function(){
					if($(this).attr('name') == name){
					$(this).attr('bgcolor','#99CCFF');
					}
					});
		}}}*/
   /*$('.id').click(function(event){
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
	*/


$('.id').click(function(event){
        var name = $(this).attr('name');
        var year = $(this).attr('year');
        var sem = $(this).attr('sem');
        var mod = $(this).attr('mod');
		if ($(this).is(":checked")){	
     
            $(this).attr('checked', true);
       
			$('tr').each(function(){
					if(($(this).attr('name') == name)&&($(this).attr('year') == year)&&($(this).attr('sem') == sem)&&($(this).attr('mod') == mod)){
					$(this).attr('bgcolor','#99CCFF');
					
					}
					});
		}else{
		
            $(this).removeAttr('checked');
        
		$('tr').each(function(){
					if(($(this).attr('name') == name)&&($(this).attr('year') == year)&&($(this).attr('sem') == sem)&&($(this).attr('mod') == mod)){
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
	
	