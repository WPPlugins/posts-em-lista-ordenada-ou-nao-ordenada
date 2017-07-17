<?php
/*
Plugin Name: Posts em Lista com Marcadores ou Numera&ccedil;&atilde;o 
Plugin URI: mailto:giosepe_luiz3@hotmail.com
Description: Cria uma lista com marcadores ou numera&ccedil;&atilde;o com posts de uma determinada categoria ou de todas.
Author: Giosepe Luiz
Version: 1.50
Author URI: mailto:giosepe_luiz3@hotmail.com
*/

$ordn_version = '1.50';

// Setup defaults if options do not exist
add_option('ordn_type', 'jump'); 
add_option('ordn_button', 'Ver'); 
add_option('ordn_default', '(selecione um post)'); 
add_option('ordn_sort', 'date_desc'); 
add_option('ordn_limit', 0); 
add_option('ordn_before_form', ''); 
add_option('ordn_after_form', ''); 
add_option('ordn_before_list', ''); 
add_option('ordn_after_list', ''); 


function ordn_add_option_pages() {
	if (function_exists('add_options_page')) {
		add_options_page('Posts em Lista com Marcadores ou Numera&ccedil;&atilde;o&nbsp;', 'Lista Ordenada e N&atilde;o Ordenada', 8, __FILE__, 'ordn_options_page');
	}		
}


function ordn_options_page() {

	global $ordn_version;

	if (isset($_POST['set_defaults'])) {
		echo '<div id="message" class="updated fade"><p><strong>';

		update_option('ordn_type', 'jump'); 
		update_option('ordn_button', 'Ver'); 
		update_option('ordn_default', '(selecione um post)'); 
		update_option('ordn_sort', 'date_desc'); 
		update_option('ordn_limit', 0); 
		update_option('ordn_before_form', ''); 
		update_option('ordn_after_form', ''); 
		update_option('ordn_before_list', ''); 
		update_option('ordn_after_list', ''); 

		echo 'Op&ccedil;&otilde;es padr&atilde;o salvas!';
		echo '</strong></p></div>';

	} else if (isset($_POST['info_update'])) {

		echo '<div id="message" class="updated fade"><p><strong>';

		update_option('ordn_type', (string)$_POST["ordn_type"]); 
		update_option('ordn_button', (string)$_POST["ordn_button"]); 
		update_option('ordn_default', (string)$_POST["ordn_default"]); 
		update_option('ordn_sort', (string)$_POST["ordn_sort"]); 
		update_option('ordn_limit', (int)$_POST["ordn_limit"]); 
		update_option('ordn_before_form', (string)$_POST["ordn_before_form"]); 
		update_option('ordn_after_form', (string)$_POST["ordn_after_form"]); 
		update_option('ordn_before_list', (string)$_POST["ordn_before_list"]); 
		update_option('ordn_after_list', (string)$_POST["ordn_after_list"]);

		echo 'Configura&ccedil;&atilde;o salva!';
		echo '</strong></p></div>';

	} ?>




	<div class=wrap>

	<h2>Posts em Lista com Marcadores ou Numera&ccedil;&atilde;o&nbsp;<?php echo $ordn_version; ?></h2>

	<p>Para mais informa&ccedil;&otilde;es, envie um e-mail para: <a href="mailto:giosepe_luiz3@hotmail.com">giosepe_luiz3@hotmail.com</a></p>
	<code>&lt;!-- ordenar # --&gt;</code> <small><i>(post ou p&aacute;gina)</i></small> ou <code>&lt;?php echo ordem(#); ?&gt;</code> <small><i>(template)</i></small>
	<br>- Insere uma lista de uma determinada categoria, onde o '#' &eacute; a ID dessa categoria.<br>
	<br><code>&lt;!-- ordenar tudo --&gt;</code> <small><i>(post ou p&aacute;gina)</i></small> ou <code>&lt;?php echo ordem('tudo'); ?&gt;</code> <small><i>(template)</i></small>
	<br>- Lista todos os posts existentes.


	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<input type="hidden" name="info_update" id="info_update" value="true" />


	<h3>Painel de Op&ccedil;&otilde;es<br></h3>
	<table width="100%" border="0" cellspacing="0" cellpadding="6">

	<tr valign="top"><td width="35%" align="right">
		<strong>Tipo de Exibi&ccedil;&atilde;o</strong> &nbsp; 
	</td><td align="left">
		<input name="ordn_type" type="radio" value="jump" <?php if (get_option('ordn_type') == "jump") echo "checked='checked'"; ?> />&nbsp;&nbsp; Lista com Marcadores (N&atilde;o Ordenada)<br />
<input name="ordn_type" type="radio" value="list" <?php if (get_option('ordn_type') == "list") echo "checked='checked'"; ?> />&nbsp;&nbsp; Lista Numerada (Ordenada)<br />
	</td></tr>

	<tr style="height:20px"><td></td><td></td></tr>

	<tr valign="top"><td width="35%" align="right">
		<strong>Classifica&ccedil;&atilde;o</strong> &nbsp; 
	</td><td align="left">
		<input name="ordn_sort" type="radio" value="date_desc" <?php if (get_option('ordn_sort') == "date_desc") echo "checked='checked'"; ?> />&nbsp;&nbsp; por data - a partir do mais novo<br />
		<input name="ordn_sort" type="radio" value="date_asc" <?php if (get_option('ordn_sort') == "date_asc") echo "checked='checked'"; ?> />&nbsp;&nbsp; por data - a partir do mais velho<br />
		<input name="ordn_sort" type="radio" value="title" <?php if (get_option('ordn_sort') == "title") echo "checked='checked'"; ?> />&nbsp;&nbsp; ordem alfab&eacute;tica<br />
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		<strong>Limite de Postagens</strong> &nbsp; 
	</td><td align="left">
		<input name="ordn_limit" type="text" size="5" value="<?php echo get_option('ordn_limit') ?>"/>
		<br /><i>N&uacute;mero de limite de posts para a lista (0 = ilimitado)</i>
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		<strong>Adicionar antes do formul&aacute;rio</strong> &nbsp; 
	</td><td align="left">
		<textarea name="ordn_before_form" cols="40" rows="4"><?php echo stripslashes(htmlspecialchars(get_option('ordn_before_form'))) ?></textarea>
		<br /><i>C&oacute;digo que ser&aacute; exibido antes do formul&aacute;rio</i>
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		<strong>Adicionar depois do formul&aacute;rio</strong> &nbsp; 
	</td><td align="left">
		<textarea name="ordn_after_form" cols="40" rows="4"><?php echo stripslashes(htmlspecialchars(get_option('ordn_after_form'))) ?></textarea>
		<br /><i>C&oacute;digo que ser&aacute; exibido depois do formul&aacute;rio</i>
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		<strong>Adicionar antes da lista</strong> &nbsp; 
	</td><td align="left">
		<textarea name="ordn_before_list" cols="40" rows="4"><?php echo stripslashes(htmlspecialchars(get_option('ordn_before_list'))) ?></textarea>
		<br /><i>C&oacute;digo que ser&aacute; exibido antes da lista</i>
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		<strong>Adicionar depois da lista</strong> &nbsp; 
	</td><td align="left">
		<textarea name="ordn_after_list" cols="40" rows="4"><?php echo stripslashes(htmlspecialchars(get_option('ordn_after_list'))) ?></textarea>
		<br /><i>C&oacute;digo que ser&aacute; exibido depois da lista</i>
	</td></tr>

	</table>

	<div class="submit">
		<input type="submit" name="set_defaults" value="<?php _e('Op&ccedil;&otilde;es Padr&atilde;o'); ?> &raquo;" />
		<input type="submit" name="info_update" value="<?php _e('Atualizar Op&ccedil;&otilde;es'); ?> &raquo;" />
	</div>

	</form>
	</div><?php
}



function lista($catID) {

	$all_cats = FALSE;
	if (strtolower(trim($catID)) == 'tudo') {
		$all_cats = TRUE;
	}


	global $wpdb;
	$tp = $wpdb->prefix;
	// Currently using a work-around for the version system
	// determines if pre or post 2.3 from wp_term_taxonomy 
	$ver = 2.2;
	$wpv = $wpdb->get_results("show tables like '{$tp}term_taxonomy'");
	if (count($wpv) > 0) {
		$ver = 2.3;
	}


	$ordn_type = get_option('ordn_type'); 
	$ordn_button = trim(get_option('ordn_button')); 
	$ordn_default = stripslashes(trim(get_option('ordn_default'))); 
	$ordn_sort = get_option('ordn_sort'); 
	$ordn_limit = (int)get_option('ordn_limit'); 
	$ordn_before_form = stripslashes(get_option('ordn_before_form')); 
	$ordn_after_form = stripslashes(get_option('ordn_after_form')); 
	$ordn_before_list = stripslashes(get_option('ordn_before_list')); 
	$ordn_after_list = stripslashes(get_option('ordn_after_list')); 
	
	$t_out = '';

	$table_prefix = $wpdb->prefix;

	$sort_code = 'ORDER BY post_date DESC';
	switch ($ordn_sort) {
		case 'date_desc': 
			$sort_code = 'ORDER BY post_date DESC';
			break;
		case 'date_asc': 
			$sort_code = 'ORDER BY post_date ASC';
			break;
		case 'title': 
			$sort_code = 'ORDER BY post_title ASC';
			break;
	}

	$limit_code = '';
	if ($ordn_limit > 0) {
		$limit_code = ' LIMIT ' . $ordn_limit;
	}


	if ($ver < 2.3) {

		$cat_sel_code = ' ';
		if (!$all_cats) {
			$cat_sel_code = " AND {$table_prefix}post2cat.category_id = {$catID} ";
		}

		$post_list = (array)$wpdb->get_results("
			SELECT ID, post_title, post_date
			FROM {$table_prefix}posts, {$table_prefix}post2cat
			WHERE {$table_prefix}posts.ID = {$table_prefix}post2cat.post_id 
			{$cat_sel_code} 
			AND post_status = 'publish' 
			AND post_type != 'page' 
			{$sort_code} 
			{$limit_code} 
		");

	} else { // post 2.3

		$cat_sel_code = ' ';
		if (!$all_cats) {
			$cat_sel_code = " AND {$table_prefix}term_taxonomy.term_id = {$catID} ";
		}

		$post_list = (array)$wpdb->get_results("
			SELECT ID, 
				post_title, 
				post_date
			FROM {$table_prefix}posts, {$table_prefix}term_relationships, {$table_prefix}term_taxonomy
			WHERE {$table_prefix}posts.ID = {$table_prefix}term_relationships.object_id
			AND {$table_prefix}term_relationships.term_taxonomy_id = {$table_prefix}term_taxonomy.term_taxonomy_id
			AND {$table_prefix}term_taxonomy.taxonomy = 'category' 
			{$cat_sel_code}
			AND post_status = 'publish' 
			AND post_type != 'page' 
			{$sort_code} 
			{$limit_code} 
		");

	}


	// use random ID when showing all
	if ($all_cats) {
		$randstr = '';
		$maxchar = 8;
		$chars = str_shuffle('abcdef1234567890');
		$len = strlen($chars);
		for ($i = 0; $i < $maxchar; $i++) {
			$randstr .= $chars[mt_rand(0, $len-1)];
		}
		$catID = $randstr;
	}


	if ($ordn_type == 'jump') {

		$t_out .= '<form class="ordn-form" name="catform' . $catID. '" id="catform' . $catID. '" action="">';
		$t_out .= $ordn_before_list;
		$t_out .= '<ul name="jumpMenu' . $catID. '" id="jumpMenu' . $catID. '">';

		if ($ordn_default == '000000') {
			$t_out .= '<li value="">' . $ordn_default . '</li>';
		}

		foreach ($post_list as $p) {
			$t_out .= '<li><a href="value="' . get_permalink($p->ID) . '"">' . $p->post_title . '</a></li>';
		}

		$t_out .= '</ul>';
		$t_out .= $ordn_after_list;
		$t_out .= '</form>';

	} else {

		$t_out .= '<form class="ordn-form" name="catform' . $catID. '" id="catform' . $catID. '">';
		$t_out .= $ordn_before_list;
		$t_out .= '<ol>';

		foreach ($post_list as $p) {
			$t_out .= '<li><a href="' . get_permalink($p->ID) . '">' . $p->post_title . '</a></li>';
		}

		$t_out .= '</ol>';
		$t_out .= $ordn_after_list;
		$t_out .= '</form>';

	}
	

	return $ordn_before_form . $t_out . $ordn_after_form;
}



function ordn_check($content) {

	// remove P tags around html comments (comment out to disable)
	$content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content); 

	$results = array();

	preg_match_all("/<!--\s?ordenar\s?(.*)\s?-->/", $content, $results);

	$i = 0;
	foreach ($results[0] as $r) {
		$content = str_replace($r, lista($results[1][$i]), $content);
		$i++;
	}

	return $content;
}



function ordn_head() {
	echo "
	<script type=\"text/javascript\">
	<!--
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
	  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
	  if (restore) selObj.selectedIndex=0;
	}
	//-->
	</script>
	";
}


add_action('admin_menu', 'ordn_add_option_pages');
add_filter('the_content', 'ordn_check');
add_action('wp_head', 'ordn_head');

?>