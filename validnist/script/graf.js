google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '��������');
        data.addColumn('number', '������� �������');
		for (var i=0;i<mas.length;i++){
		data.addRows([[String(i+1), parseFloat(mas[i])]]);
		}
	    var lv = new google.visualization.DataTable();
        lv.addColumn('string', '��������');
        lv.addColumn('number', '���� �������');
		lv.addColumn('number', '���� �������');
		for (var i=1;i<mas.length+1;i++){
		lv.addRows([[String(i), parseFloat(masl[i]),parseFloat(masv[i])]]);
		}	
        //var options = {legend: 'none', title: '��������� ������ ��������� �����', hAxis: { title: '�������', titleTextStyle: {color: 'green'} },vAxis:{maxValue: 100}
		 var options = {legend: 'none',title: '��������� ������ ��������� ����� %', hAxis: { title: '�������', titleTextStyle: {color: 'green'} }
        };
		var optionslv = {axisTitlesPosition: 'out',title: '��������� ������ ������ �� ������ ������ %', hAxis: { title: '�������', titleTextStyle: {color: 'green'} }
        };
 

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_divlv'));
        chart.draw(lv, optionslv);
  
      }

function formWind()
{
	var newWind = window.close();
    newWind = window.open('', 'newwin', 'width=200, height=50, top=100, left=450, status=no, location=no, toolbar=no, menubar=no');
	newWind.document.write('<center>�������� �� �� ���<br>');
    newWind.document.write('³������ ��� ������<input type="checkbox" name=" ">');

}

 