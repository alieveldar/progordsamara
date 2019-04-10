<? 
$datenow=date("d-m-Y");
echo <<<HTML
<div class="row-fluid">
	<h2>Отчеты</h2>
	<div style="width:300px;">    
			<table class="table">
				<thead>
					<tr>
						<th> <a href="#" class="btn small" id="dp4" data-date-format="dd-mm-yyyy" data-date="$datenow">Начало</a></th>
						<th> <a href="#" class="btn small" id="dp5" data-date-format="dd-mm-yyyy" data-date="$datenow">Конец</a></th>
						<th><a class="btn btn-primary" onclick="showstats();" href="#show">Показать</a></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td id="startDate">$datenow</td>
						<td id="endDate">$datenow</td>
						<td id="no"></td>
					</tr>
				</tbody>
			</table>
			
	</div>
<div id="blockstats">
</div>
HTML;

?>