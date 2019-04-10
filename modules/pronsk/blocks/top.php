<?php

$social = '';

foreach ($BasVARS as $var) {
    if ($var['name'] === 'nsk_social') {
        $social = $var['value'];
    }
}

$topText2 = '';
$topText = "<div id='ProHead'>
		<div class='logo'><a href='/'><img src='/template/pronsk/logo.png' /></a></div>
		<div class='navs'>
			<div class='user'><!--USER--></div>
			<div class='navsicon'>".$social."</div>
			<div class='wdgt2'>".getWidgetsInHead()."</div>
		</div><div class='C'></div>
		<div class='menu'>".$MENU['pronsk']."</div><div class='C'></div>
		<div class='wdgt'>".$topText2."</div><div class='C'></div>
	</div>
	<div class='C15'></div>
	<!-- <div id='MainTags'>".$MENU["maintags"]."</div> -->";
// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

$Page['TopContent'] = $topText;
