<?php 
/* 
Plugin Name: vozMe
Plugin URI: http://vozme.com
Version: 1.5
Author: <a href="http://vozme.com">vozme.com</a>
Description: A plugin that turns text to speech
*/ 


$vozme_current_title = '';

function vozme_set_current_title($title){
	global $vozme_current_title;
	$vozme_current_title = $title;
	return $title;
}

function vozme_set_default_values_if_not_exist(){
	if(!get_option("vozme_lang") || get_option("vozme_lang") == ''){
		update_option("vozme_lang","en");
	}
	if(!get_option("vozme_voice") || get_option("vozme_voice") == ''){
		update_option("vozme_voice","ml");
	}
	if(!get_option("vozme_display_mode") || get_option("vozme_display_mode") == ''){
		update_option("vozme_display_mode","1");
	}
	if(!get_option("vozme_display_position") || get_option("vozme_display_position") == ''){
		update_option("vozme_display_position","center");
	}
}

function vozme_is_selected_lang($lang){
	if(get_option("vozme_lang")==$lang){
		return 'selected="selected"';
	} else {
		return '';
	}
}

function vozme_is_selected_voice($voice){
	if(get_option("vozme_voice")==$voice){
		return 'selected="selected"';
	} else {
		return '';
	}
}

function vozme_is_selected_display_mode($display_mode){
	if(get_option("vozme_display_mode")==$display_mode){
		return 'checked="checked"';
	} else {
		return '';
	}
}

function vozme_is_selected_display_position($display_position){
	if(get_option("vozme_display_position")==$display_position){
		return 'checked="checked"';
	} else {
		return '';
	}
}

function vozme_add_link($content){
	vozme_set_default_values_if_not_exist();
	global $vozme_current_title;
	$vozme_current_title = rtrim($vozme_current_title);
	if(substr($vozme,-1,1)!='.' || substr($vozme,-1,1)!='!' || substr($vozme,-1,1)!='?' || substr($vozme,-1,1)!=';' || substr($vozme,-1,1)!=','){
		$vozme_current_title = $vozme_current_title.".";
	}
	$vozme_guid = md5(get_the_guid());
	
	if(get_option("vozme_lang") == 'es'){
		$l_hear = "Escucha";
		$l_this_post = "este post";
	} else if (get_option("vozme_lang") == 'en'){
		$l_hear = "Hear";
		$l_this_post = "this post";
	} else if (get_option("vozme_lang") == 'it'){
		$l_hear = "Ascolta";
		$l_this_post = "questo post";
    } else if (get_option("vozme_lang") == 'pt'){
		$l_hear = "Ouça";
		$l_this_post = "este post";
	} else if (get_option("vozme_lang") == 'ca'){
		$l_hear = "Escolta";
		$l_this_post = "aquest post";
	}

	$content.='<form id="vozme_form_'.$vozme_guid.'" method="post" name="vozme_form_'.$vozme_guid.'" target="'.$vozme_guid.'" action="http://vozme.com/text2voice.php">';
	$content.='<input name="text" type="hidden" value="'.str_replace("'",'&quot;',str_replace('"','&quot;',strip_tags($vozme_current_title)))." ".str_replace("'",'&quot;',str_replace('"','&quot;',strip_tags($content))).'" />';
	$content.='<input name="lang" type="hidden" value="'.get_option("vozme_lang").'" />';
	$content.='<input name="gn" type="hidden" value="'.get_option("vozme_voice").'" />';
	$content.='<input type="hidden" id="interface" name="interface" value="full" />';
	if(get_option("vozme_display_mode") == '1'){
		if(get_option("vozme_display_position") == 'center'){
			$content.='
			<div style="margin-left:40%;">
			';
		} else {
			$content.='
			<div style="text-align:'.get_option("vozme_display_position").';">
			';
		}
		$content.='
				<input style="float:left;" type="image" width="40" height="40" src="'.get_option('siteurl').'/wp-content/plugins/vozme/img/megaphone40x40w.gif" alt="'.$l_hear.' '.$l_this_post.'" onclick="window.open(\'\', \''.$vozme_guid.'\', \'width=600,height=370,scrollbars=yes,location=yes,menubar=yes,resizable=yes,status=yes,toolbar=yes\');">
				<div style="margin-left:48px; text-align:left;"><a style="font-size:12px;" href="javascript:void(0);" onclick="window.open(\'\', \''.$vozme_guid.'\', \'width=600,height=370,scrollbars=yes,location=yes,menubar=yes,resizable=yes,status=yes,toolbar=yes\'); document.getElementById(\'vozme_form_'.$vozme_guid.'\').submit();">'.$l_hear.'<br/>'.$l_this_post.'</a></div>
			</div>';
	} else if(get_option("vozme_display_mode") == '2'){
		if(get_option("vozme_display_position") == 'center'){
			$content.='
			<div style="margin-left:40%;">
			';
		} else {
			$content.='
			<div style="text-align:'.get_option("vozme_display_position").';">
			';
		}
		$content.='
				<input style="float:left;" type="image" width="32" height="32" src="'.get_option('siteurl').'/wp-content/plugins/vozme/img/paper_sound32x32.gif" alt="'.$l_hear.' '.$l_this_post.'" onclick="window.open(\'\', \''.$vozme_guid.'\', \'width=600,height=370,scrollbars=yes,location=yes,menubar=yes,resizable=yes,status=yes,toolbar=yes\');">
				<div style="margin-left:40px; text-align:left;"><a style="font-size:12px;" href="javascript:void(0);" onclick="window.open(\'\', \''.$vozme_guid.'\', \'width=600,height=370,scrollbars=yes,location=yes,menubar=yes,resizable=yes,status=yes,toolbar=yes\'); document.getElementById(\'vozme_form_'.$vozme_guid.'\').submit();">'.$l_hear.'<br/>'.$l_this_post.'</a></div>
			</div>';
	}
	$content.='</form>';

	return $content;
}

function vozme_plugin_menu() {
	add_options_page('Vozme plugin options', 'Vozme', 8, __FILE__, 'vozme_display_options');
}

function vozme_display_options(){
	if(isset($_POST['v_updated'])){
        update_option("vozme_lang", $_POST['v_lang']); 
        update_option("vozme_voice", $_POST['v_voice']); 
        update_option("vozme_display_mode", $_POST['v_display_mode']);
        update_option("vozme_display_position", $_POST['v_display_position']);
	} else {
		vozme_set_default_values_if_not_exist();
	}

	if(get_option("vozme_lang") == 'es'){
		$l_h2 = "Opciones de vozMe";
		$l_language = "Idioma";
        $l_voice = "Voz";
        $l_male = "Masculina";
        $l_female = "Femenina";
		$l_display_mode = "Aspecto";
		$l_display_position = "Posición";
		$l_left = "izquierda";
		$l_center = "centro";
		$l_update = "Actualizar";
		$l_hear = "Escucha";
		$l_this_post = "este post";
	} else if (get_option("vozme_lang") == 'en'){
		$l_h2 = "vozMe options";
		$l_language = "Language";
        $l_voice = "Voice";
        $l_male = "Male";
        $l_female = "Female";
		$l_display_mode = "Display";
		$l_display_position = "Position";
		$l_left = "left";
		$l_center = "center";
		$l_update = "Update";
		$l_hear = "Hear";
		$l_this_post = "this post";
	} else if (get_option("vozme_lang") == 'it'){
		$l_h2 = "Opzioni di vozMe";
		$l_language = "Idioma";
        $l_voice = "Voce";
        $l_male = "Maschile";
        $l_female = "Femminile";
		$l_display_mode = "Modalità di visualizzazione";
		$l_display_position = "Posizione";
		$l_left = "Sinistra";
		$l_center = "Centro";
		$l_update = "Aggiornare";
		$l_hear = "Ascolta";
		$l_this_post = "questo post";
	} else if (get_option("vozme_lang") == 'pt'){
		$l_h2 = "Opções de vozMe";
		$l_language = "Idioma";
        $l_voice = "Voz";
        $l_male = "Masculina";
        $l_female = "Femmenina";
		$l_display_mode = "Modo";
		$l_display_position = "Posição";
		$l_left = "Esquerda";
		$l_center = "Centro";
		$l_update = "Atualizar";
		$l_hear = "Ouça";
		$l_this_post = "este post";
	} else if (get_option("vozme_lang") == 'ca'){
		$l_h2 = "Opcions de vozMe";
		$l_language = "Idioma";
        $l_voice = "Veu";
        $l_male = "Masculina";
        $l_female = "Femenina";
		$l_display_mode = "Aspecte";
		$l_display_position = "Posició";
		$l_left = "Esquerra";
		$l_center = "Centre";
		$l_update = "Actualitzar";
		$l_hear = "Escolta";
		$l_this_post = "aquest post";
	}

	echo '
	<div class="wrap">
	<h2>'.$l_h2.'</h2>
	<form method="post" name="v_options" id="v_options" target="_self">
	<table class="optiontable">
	<input name="v_updated" type="hidden" value="true" />
	<tr valign="top">
	<th scope="row">'.$l_language.': </th>
	<td>
	<select name="v_lang" id="v_lang">
		<option value="es" '.vozme_is_selected_lang('es').' onclick="document.getElementById(\'v_options\').submit();">Español</option>
		<option value="en" '.vozme_is_selected_lang('en').' onclick="document.getElementById(\'v_options\').submit();">English</option>
		<option value="it" '.vozme_is_selected_lang('it').' onclick="document.getElementById(\'v_options\').submit();">Italiano</option>
		<option value="pt" '.vozme_is_selected_lang('pt').' onclick="document.getElementById(\'v_options\').submit();">Português</option>
		<option value="ca" '.vozme_is_selected_lang('ca').' onclick="document.getElementById(\'v_options\').submit();">Català</option>
	</select>
	</td>
	</tr>

	<tr valign="top">
	<th scope="row">'.$l_voice.': </th>
	<td>
	<select name="v_voice" id="v_voice">
		<option value="ml" '.vozme_is_selected_voice('ml').'>'.$l_male.'</option>
		<option value="fm" '.vozme_is_selected_voice('fm').'>'.$l_female.'</option>
	</select>
	</td>
	</tr>

	<tr valign="top">
	<th scope="row">'.$l_display_mode.':</th>
	<td valign="top">
	<div style="float:left;">
		<input id="v_display_mode" type="radio" name="v_display_mode" value="1"  '.vozme_is_selected_display_mode('1').'/> 
		<img style="margin-left:5px;" width="40" height="40" src="'.get_option('siteurl').'/wp-content/plugins/vozme/img/megaphone40x40w.gif" alt="">
	</div>
	<div style="margin-left:74px; font-size:12px;"><a href="void(0);">'.$l_hear.'<br/>'.$l_this_post.'</a></div>

	<div style="clear:both;">&nbsp;</div>

	<div style="float:left;">
		<input id="v_display_mode" type="radio" name="v_display_mode" value="2"  '.vozme_is_selected_display_mode('2').'/> 
		<img style="margin-left:5px;" width="32" height="32" src="'.get_option('siteurl').'/wp-content/plugins/vozme/img/paper_sound32x32.gif" alt="">
	</div>
	<div style="margin-left:66px; font-size:12px;"><a href="void(0);">'.$l_hear.'<br/>'.$l_this_post.'</a></div>

	</td>
	</tr>

	<tr valign="top">
	<th scope="row">'.$l_display_position.':</th>
	<td>
	<input id="v_display_position" type="radio" name="v_display_position" value="left"  '.vozme_is_selected_display_position('left').' /> '.$l_left.'
	&nbsp;&nbsp;<input id="v_display_position" type="radio" name="v_display_position" value="center"  '.vozme_is_selected_display_position('center').' /> '.$l_center.'
	</td>
	</tr>

	<tr valign="top">
	<th scope="row"></th>
	<td>
	<input type="submit" name="v_submit" id="v_submit" value="'.$l_update.'" />
	</td>
	</tr>
	</table>
	</form>
	</div>
	';
}

add_action('admin_menu', 'vozme_plugin_menu');
add_filter('the_title', 'vozme_set_current_title');
add_filter('the_content', 'vozme_add_link');
?>
