<?
echo <<<HTML
	 <!-- profile -->
    <div id="profile" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Сменить пароль</h3>
    </div>
    <div class="modal-body" id="blockeditprofile$userinfo[user_id]">
HTML;
	returneditprofileform($id=$userinfo['user_id'],$allowsafe=1, $message="");
echo <<<HTML
	</p>
    </div>
    <div class="modal-footer">
    <button id="editprofileclosemodal" class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
	<div id="profilesafebutton" style="display: inline-block;"><button class="btn btn-primary" onclick="profile($userinfo[user_id]);">Сохранить</button></div>
    </div>
    </div>
HTML;
?>