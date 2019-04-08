function profile(id) 
	{
	var profilemurl = '/ajax/edit_profile_ajax.php?id=' + id;
	var profileblock = '#blockeditprofile' + id;
				jQuery.ajax({
					type: "POST",
					url: profilemurl,
 					data: 'oldpass='+jQuery('#oldpass').val()+'&newpass='+jQuery('#newpass').val()+'&confirmnewpass='+jQuery('#confirmnewpass').val(),
					success: function(html){
                        jQuery(profileblock).empty();
						jQuery(profileblock).append(html);
				   }
				});
				return false;
	}
function showstats() 
	{
	var url = '/ajax/show_stats.php';
	var block = '#blockstats';
				jQuery.ajax({
					type: "POST",
					url: url,
 					data: 'datef='+jQuery('#startDate').text()+'&datet='+jQuery('#endDate').text(),
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
	}
function adddept()
	{
	var url = '/ajax/add_dept.php';
	var block = '#adddeptform';
				jQuery.ajax({
					type: "POST",
					url: url,
 					data: 'deptname='+jQuery('#deptname').val(),
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
	}	
function addworkers()
	{
	var url = '/ajax/add_worker.php';
	var block = '#addworkersform';
				jQuery.ajax({
					type: "POST",
					url: url,
 					data: 'name='+jQuery('#workername').val() + '&working='+jQuery('#workerwork').val() + '&workerdept='+jQuery('#workerdept').val(),
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
	}
function addmeet(id)
	{
	var url = '/ajax/add_meet.php';
	var block = '#addmeetformres';
				jQuery.ajax({
					type: "POST",
					url: url,
 					data: 	'cp=' + jQuery('#cp').val() + 
							'&cpcomm=' + jQuery('#cpcomm').val() + 
							'&cf=' + jQuery('#cf').val() + 
							'&cfcomm=' + jQuery('#cfcomm').val() +
							
							'&kp=' + jQuery('#kp').val() +
							'&kpcomm=' + jQuery('#kpcomm').val() +
							'&kf=' + jQuery('#kf').val() +
							'&kfcomm=' + jQuery('#kfcomm').val() +
							
							'&fp=' + jQuery('#fp').val() +
							'&fpcomm=' + jQuery('#fpcomm').val() +
							'&ff=' + jQuery('#ff').val() +
							'&ffcomm=' + jQuery('#ffcomm').val() +
							
							'&pp=' + jQuery('#pp').val() +
							'&ppcomm=' + jQuery('#ppcomm').val() +
							'&pf=' + jQuery('#pf').val() +
							'&pfcomm=' + jQuery('#pfcomm').val() +
							
							'&tp=' + jQuery('#tp').val() +
							'&tpcomm=' + jQuery('#tpcomm').val() +
							'&tf=' + jQuery('#tf').val() +
							'&tfcomm=' + jQuery('#tfcomm').val() +
							
							'&dp=' + jQuery('#dp').val() +
							'&dpcomm=' + jQuery('#dpcomm').val() +
							'&df=' + jQuery('#df').val() +
							'&dfcomm=' + jQuery('#dfcomm').val() +
							
							'&date=' + jQuery('#meetdate').val() +
							'&workerid=' + id,
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
	}		
function deletedeptmodal(id,name)
		{
        jQuery('#deletedept').modal('show');
		var block = '#deletedeptarea';
        jQuery(block).empty();
		jQuery(block).append("<input type='hidden' name='deleteid' id='deleteid' value='" + id + "'>Вы действительно хотите удалить отдел " + name + "?");
		}
function deleteworkermodal(id,name)
		{
        jQuery('#deleteworker').modal('show');
		var block = '#deleteworkerarea';
        jQuery(block).empty();
		jQuery(block).append("<input type='hidden' name='deleteid' id='deleteid' value='" + id + "'>Вы действительно хотите удалить сотрудника " + name + " и его статистику?");
		}
function deletemeetmodal(id,name)
		{
        jQuery('#deletemeet').modal('show');
		var block = '#deletemeetarea';
        jQuery(block).empty();
		jQuery(block).append("<input type='hidden' name='deleteid' id='deletemid' value='" + id + "'>Вы действительно хотите удалить встречу " + name + " ?");
		document.getElementById('deletemeetbutton').innerHTML = "<button class='btn btn-primary' onclick='dodeletemeet();'>Удалить</button>"
		}
function dodeletedept() 
{
var url = '/ajax/delete_dept.php';
var block = '#deletedeptarea';
				jQuery.ajax({
					type: "POST",
					url: url,
					data: 'id='+jQuery('#deleteid').val(),
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
			
	}
	
	
function dodeleteworker() 
{
var url = '/ajax/delete_worker.php';
var block = '#deleteworkerarea';
				jQuery.ajax({
					type: "POST",
					url: url,
					data: 'id='+jQuery('#deleteid').val(),
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
			
	}
function dodeletemeet() 
{
var url = '/ajax/delete_meet.php';
var block = '#deletemeetarea';
				jQuery.ajax({
					type: "POST",
					url: url,
					data: 'id='+jQuery('#deletemid').val(),
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
			
	}
function showhistory(id,from) 
{
var url = '/ajax/show_worker_history.php';
var block = '#historyarea';
				jQuery.ajax({
					type: "POST",
					url: url,
					data: 'id='+id+'&from='+from,
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
	}
	
function showdepthistory(id,from) 
{
var url = '/ajax/show_dept_history.php';
var block = '#depthistoryarea';
				jQuery.ajax({
					type: "POST",
					url: url,
					data: 'id='+id+'&from='+from,
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
	}
function editworkermodal(id)
		{
        jQuery('#editworker').modal('show');
		var url = '/ajax/edit_worker.php';
		var block = '#newworkernameblock';
				jQuery.ajax({
					type: "POST",
					url: url,
 					data: 'id='+id,
					success: function(html){
                    jQuery(block).empty();
					jQuery(block).append(html);
				   }
				});
				return false;
				
		}
function editmeetingmodal(id)
		{
		document.getElementById('editmeetbutton').innerHTML = "<button class='btn btn-primary' onclick='editmeetsave();'>Сохранить</button>";	
        jQuery('#editmeet').modal('show');
		var url = '/ajax/edit_meeting.php';
		var block = '#newmeetblock';
				jQuery.ajax({
					type: "POST",
					url: url,
 					data: 'id='+id,
					success: function(html){
                    jQuery(block).empty();
					jQuery(block).append(html);
				   }
				});
				return false;
				
		}
function editmeetsave() 
{
var url = '/ajax/save_edit_meeting.php';
var block = '#newmeetblock';
				jQuery.ajax({
					type: "POST",
					url: url,
					data: 'chmid='+jQuery('#chmid').val()+'&changemeetdate='+jQuery('#changemeetdate').val()+'&nowtype='+jQuery('#nowtype').val()+'&chf='+jQuery('#chf').val()+'&chpcom='+jQuery('#chpcom').val()+'&chfcom='+jQuery('#chfcom').val()+'&chp='+jQuery('#chp').val()+'&olddate='+jQuery('#olddate').val(),
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
	}
function editworkersave() 
{
var url = '/ajax/save_edit_worker.php';
var block = '#editworkerform';
				jQuery.ajax({
					type: "POST",
					url: url,
					data: 'nowdept='+jQuery('#nowdept').val()+'&newworkername='+jQuery('#newworkername').val()+'&newworking='+jQuery('#newworking').val()+'&editworkerid='+jQuery('#editworkerid').val()+'&workernowname='+jQuery('#workernowname').val()+'&nowworking='+jQuery('#nowworking').val()+'&nowdeptid='+jQuery('#nowdeptid').val(),
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
			
	}
function editdeptmodal(id)
		{
        jQuery('#editdept').modal('show');
		var url = '/ajax/edit_dept.php';
		var block = '#newdeptnameblock';
				jQuery.ajax({
					type: "POST",
					url: url,
 					data: 'id='+id,
					success: function(html){
                    jQuery(block).empty();
					jQuery(block).append(html);
				   }
				});
				return false;
				
		}
function editdeptsave() 
{
var url = '/ajax/save_edit_dept.php';
var block = '#editdeptform';
				jQuery.ajax({
					type: "POST",
					url: url,
					data: 'newdeptname='+jQuery('#newdeptname').val()+'&id='+jQuery('#editdeptid').val()+'&deptnowname='+jQuery('#deptnowname').val(),
					
					success: function(html){
                        jQuery(block).empty();
						jQuery(block).append(html);
				   }
				});
				return false;
			
	}
function hideblock(block)
{
document.getElementById(block).innerHTML = "";	
}
    $(document).ready(function() {
			$('#adddept').on('hide', function () {
			location.reload();
			});
			$('#editdept').on('hide', function () {
			location.reload();
			});
			$('#deletedept').on('hide', function () {
			location.reload();
			});
			$('#addworkers').on('hide', function () {
			location.reload();
			});
			$('#editworker').on('hide', function () {
			location.reload();
			});
			$('#deleteworker').on('hide', function () {
			location.reload();
			});
            $('#adddeptclosemodal').click(function() {
                location.reload();
            });
			$('#editprofileclosemodal').click(function() {
                location.reload();
            });
			$('#closeeditdeptbutton').click(function() {
                location.reload();
            });
			$('#closedeletedeptbutton').click(function() {
                location.reload();
            });
			$('#addworkersclosemodal').click(function() {
                location.reload();
            });	
			$('#closedeleteworkerbutton').click(function() {
                location.reload();
            });		
			$('#closeeditworkerbutton').click(function() {
                location.reload();
            });	
			$('#closedeletemeetbutton').click(function() {
                //location.reload();
            });	
			$('#addmeetsarea').click(function() {
               document.getElementById('safeerrors').innerHTML = "";
            });	
			$('#meetingdate').datepicker();
			$('#editmeetingdate').datepicker();
			
			
			$('#nextworker').click(function() {
			//$('option:selected', '#workerlist').removeAttr('selected').next('option').attr('selected', 'selected');
			});

			$('#dp4').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() > endDate.valueOf()){
						$('#alert').show().find('strong').text('Начальная дата не может быть больше, чем конечная!');
					} else {
						$('#alert').hide();
						startDate = new Date(ev.date);
						$('#startDate').text($('#dp4').data('date'));
					}
					$('#dp4').datepicker('hide');
				});
			$('#dp5').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() < startDate.valueOf()){
						$('#alert').show().find('strong').text('Конечная дата не может быть меньше, чем начальная!');
					} else {
						$('#alert').hide();
						endDate = new Date(ev.date);
						$('#endDate').text($('#dp5').data('date'));
					}
					$('#dp5').datepicker('hide');
				});
			
             showstats();
			 
			     $("#howto").click(function () {
					$("#howtoblock").toggle();
				});
				
				if (jQuery('#showmeetcomment').text.length > 10) jQuery('#showmeetcomment').append(jQuery('#showmeetcomment').text.substr(0, 7) + '...');
				
           
        });
		

