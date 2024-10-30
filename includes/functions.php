<?php 
session_start();
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
function gocrm_menu() {
	add_menu_page( 'GoAbroad HQ Plugin Welcome', 'GoAbroad HQ Plugin', 'manage_options', 'go_crm', 'gocrm_page_options', plugins_url( 'hq-goabroad/images/icon.png' ), '90' );
	add_submenu_page( 'go_crm', 'GoAbroad HQ Plugin', 'CRM Add Form', 'manage_options', 'gocrmforms', 'gocrm_forms');
}

function gocrm_forms() { 
	global $wpdb; 
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} 
	$optionv = get_hq_fields();
	if (!isset($_GET['edit'])) { 
	$postsv = $_POST;
	$l = count($postsv['inputfield']);
	$title = "Add Form";
	echo '<div class="wrap">';
	echo '<h1 class="wp-heading-inline">'.$title.'</h1> <br /> <br />';
	if ($l > 0) {
		check_admin_referer( 'gocrm_nonce_verify' );
		$groupid = gocrm_add_form_group(sanitize_text_field($postsv['formgroup']), sanitize_text_field($postsv['form_type']));
		for ($i = 0; $i <= $l-1; $i++) {
			gocrm_add_forms_fields($groupid, sanitize_text_field($postsv['fieldname'][$i]), sanitize_text_field($postsv['inputfield'][$i]), sanitize_text_field($postsv['sort'][$i]), sanitize_text_field($postsv['required'][$i]));
		}
		echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Form has been Added. </p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	}
	echo '<form method="post" action="?page=gocrmforms">

	<table class="form-table">
		<tr>
			<td style="width:80px;padding:5px;"><label>Form Name</label> </td>
			<td style="padding:5px;"><input type="text" class="regular-text" name="formgroup" /></td>
		</tr>
		<tr>
			<td style="width:80px;padding:5px;"><label>Form Type</lable></td>
			<td style="padding:5px;">
				<select class="regular-text" id="form_type" name="form_type">
					<option value="leads">Lead Form</option>
					<option value="participants">Participants Form</option>
				</select>
			</td>
		</tr>
	</table>
	<br />
';
	wp_nonce_field( 'gocrm_nonce_verify');
	echo '
		<table class="wp-list-table widefat fixed striped gocrmforms">
			<thead>
				<th width="40%">Input Field</th>
				<th width="15%">Field Label</th>
				<th width="10%">Order</th>
				<th width="5%">Required</th>
				<th width="5%">Action</th>
			</thead>
			<tbody>
			<tr>
				<td><select class="formfields" name="inputfield[]">'.$optionv.'</td>
				<td><input type="text" value="" class="fieldname" placeholder="Label" name="fieldname[]"/></td>
				<td><input style="width:40px;" class="sort" type="text" value="1" name="sort[]"/></td>
				<td><select name="required[]"><option value="0">No</option><option value="1">Yes</option></select></td>
				<td><a class="removefield dashicons-before dashicons-dismiss"></a></td>
			</tr>
			<tr class="addtofield">
				<td colspan="5" style="text-align:left;">
				<a class="addfield dashicons-before dashicons-plus-alt" style="cursor:pointer;">Add Field</a>
 <br />
</td>
			</tr>
			</tbody>
		</table>
		<p class="submit"><input name="submit" id="submit" class="button button-primary" value="Save Form" type="submit"> <a class="button button-primary" href="?page=go_crm" >Cancel</a></p>
	</form>
	<script>
	jQuery(function ($) {
		$(".addfield").click(function () { 
			lastorder =  $(".gocrmforms tbody tr:nth-last-child(2) .sort").val();
			var fclone = $(".gocrmforms tbody tr:nth-last-child(2)").html();
			fclone = fclone.replace(\'a data-field\', \'a data-old\');
			$(".addtofield").before("<tr data-section=\'new\'>"+fclone+"</tr>");
			$(".gocrmforms tbody tr:nth-last-child(2) .sort").val((lastorder * 1) + 1);
			$(".gocrmforms tbody tr:nth-last-child(2) .fieldname").val("");
		});
		$(".gocrmforms").on("click", ".removefield", function(){
			$(this).parents("tr").remove();
		});
		$("#form_type").on("change", function() {
			var idfrom = $(this).val();
			if (idfrom=="leads") { 
				$(".formfields optgroup[label=\'LEAD FIELDS\']").removeAttr("hidden");
				$(".formfields optgroup[label=\'PARTICIPANTS FIELDS\']").attr("hidden", "hidden");
			} else { 
				$(".formfields optgroup[label=\'LEAD FIELDS\']").attr("hidden", "hidden");
				$(".formfields optgroup[label=\'PARTICIPANTS FIELDS\']").removeAttr("hidden");
			}
			
		});
	});
	</script>
	';
	
	echo '</div>';	
	} else  { 
	$title = "Edit Form";
	$ftype = $_GET['ftype'];
	
	$fn = $wpdb->get_results("SELECT ff.id, ff.form_group_id, ff.form_label, ff.form_name, ff.sort, ff.required, fg.group_name  FROM ".$wpdb->prefix."gocrm_form_fields as ff LEFT JOIN ".$wpdb->prefix."gocrm_form_group as fg ON fg.id = ff.form_group_id WHERE fg.id = '".$_GET['edit']."' ORDER BY sort ASC");

	echo '<div class="wrap">';
	echo '<h1 class="wp-heading-inline">'.$title.'</h1> 
	<p>To delete click : <a class="removefield dashicons-before dashicons-dismiss"></a></p>
	<p>To save click : <a class="removefield dashicons-before dashicons-yes"></a></p>
	';
	?><form method="post" action="?page=gocrmforms">
	<table class="form-table">
		<tr>
			<td style="width:80px;padding:5px;"><label>Form Name</label> </td>
			<td style="padding:5px;"><input type="text" value="<?php echo sanitize_text_field($_GET['name']); ?>" class="regular-text formgroup"  name="formgroup" /> <a class="saveformgroup dashicons-before dashicons-yes" data-group="<?php echo $_GET['edit']; ?>"></a></td>
		</tr>
		<tr>
			<td style="width:80px;padding:5px;"><label>Form Type</lable></td>
			<td style="padding:5px;">
				<select class="regular-text" id="form_type" name="form_type" disabled>
				<?php if ($ftype=="participants") { ?>
					<option value="participants">Participants Form</option>
				<?php } else { ?>
					<option value="leads">Lead Form</option>
				<?php } ?>
				</select>
			</td>
		</tr>
	</table>
	<br />
	<?php
	wp_nonce_field( 'gocrm_nonce_verify');
	echo '
		<table class="wp-list-table widefat fixed striped gocrmforms">
			<thead>
				<th width="40%">Input Field</th>
				<th width="15%">Field Label</th>
				<th width="10%">Order</th>
				<th width="5%">Required</th>
				<th width="5%">Action</th>
			</thead>
			<tbody>';
		foreach ($fn as $key => $row) {
			?>
				<tr data-row="<?php echo $row->id; ?>" data-section="old">
				<td><select class="inputfield" name="inputfield[]"><?php echo get_hq_fields_type($ftype, $row->form_name); ?></td>
				<td><input class="fieldname" type="text" value="<?php echo $row->form_label; ?>" placeholder="Label" name="fieldname[]"/></td>
				<td><input class="sort" type="text" style="width:40px;" value="<?php echo $row->sort; ?>" name="sort[]"/></td>
				<td><select class="required" name="required[]"><option value="0" <?php if ($row->required=='0') { echo 'selected="selected"'; } ?>>No</option><option value="1" <?php if ($row->required=='1') { echo 'selected="selected"'; } ?>>Yes</option></select></td>
				<td><a data-field="<?php echo $row->id; ?>" class="removefield dashicons-before dashicons-dismiss"></a><a data-field="<?php echo $row->id; ?>" class="savefield dashicons-before dashicons-yes" data-group="<?php echo $row->form_group_id; ?>"></a></td>
				</tr>
			<?php
		}
	?>
			<tr class="addtofield">
				<td colspan="5" style="text-align:left;"><a class="addfield dashicons-before dashicons-plus-alt
" style="cursor:pointer;">Add Field</a> | <a style="cursor:pointer;" href="?page=go_crm&t=fg" >Cancel</a></td>
			</tr>
			</tbody>
		</table>
	</form>
	<script>
	jQuery(function ($) {
		$(".addfield").click(function () { 
			lastorder =  $(".gocrmforms tbody tr:nth-last-child(2) .sort").val();
			var fclone = $(".gocrmforms tbody tr:nth-last-child(2)").html();
			fclone = fclone.replace('a data-field', 'a data-old');
			$(".addtofield").before("<tr data-section='new'>"+fclone+"</tr>");
			$(".gocrmforms tbody tr:nth-last-child(2) .sort").val((lastorder * 1) + 1);
			$(".gocrmforms tbody tr:nth-last-child(2) .fieldname").val("");
		});
		$(".gocrmforms").on("click", ".removefield", function(e){
			e.preventDefault(); // stop post action
			$(this).parents("tr").remove();
			jQuery.ajax({
			  type: "POST",
			  url: '<?php echo admin_url('admin-ajax.php'); ?>', // or '
			  data: {
				  'action': 'gocrm_delete_field',
				  'id': jQuery(this).attr("data-field")
			  },
			  success: function(){
					alert("Field has been deleted.");
			  },
			  error: function(){
				  alert('error')
			  }
		  }); 
		});
		$(".form-table").on("click", ".saveformgroup", function(e){
			e.preventDefault();
			formgroupname = $(".formgroup").val();
			form_group_id = $(this).attr("data-group");
			jQuery.ajax({
			  type: "POST",
			  url: '<?php echo admin_url('admin-ajax.php'); ?>', // or '
			  data: {
				  'action': 'gocrm_update_formname',
				  'formgroup': formgroupname,
				  'form_group_id': form_group_id
			  },
			  success: function(){
				  alert("Form Name has been updated.");
			  },
			  error: function(){
				  alert('error')
			  }
		  }); 
		});
		$(".gocrmforms").on("click", ".savefield", function(e){
			e.preventDefault();
			datasection = $(this).parents("tr").attr("data-section");
			form_group_id = $(this).attr("data-group");
			inputfield = $(this).parents("tr").find(".inputfield").val();
			fieldname = $(this).parents("tr").find(".fieldname").val();
			sort = $(this).parents("tr").find(".sort").val();
			required = $(this).parents("tr").find(".required").val();
			if (datasection=="old") { 
				datarow = $(this).parents("tr").attr("data-row");
				jQuery.ajax({
					  type: "POST",
					  url: '<?php echo admin_url('admin-ajax.php'); ?>', // or '
					  data: {
						  'action': 'gocrm_update_field',
						  'form_label': fieldname,
						  'form_name': inputfield,
						  'sort': sort,
						  'required': required,
						  'id': datarow
					  },
					  success: function(){
						  alert("Field has been updated.");
					  },
					  error: function(){
						  alert('error')
					  }
				  }); 
			} else { 
				jQuery.ajax({
					  type: "POST",
					  url: '<?php echo admin_url('admin-ajax.php'); ?>', // or '
					  data: {
						  'action': 'gocrm_add_field',
						  'form_label': fieldname,
						  'form_group_id': form_group_id,
						  'form_name': inputfield,
						  'sort': sort,
						  'required': required
					  },
					  success: function(){
						 alert("Field has been added.");
					  },
					  error: function(){
						  alert('error')
					  }
				  }); 
			}
			
		});
	});
	jQuery(document).on('click', '#submitme', function(event){ // use jQuery no conflict methods replace $ with "jQuery"

        event.preventDefault(); // stop post action

      
  });
	</script>
	<?php
		
	}
}

function gocrm_page_options() {
	global $wpdb;
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	$tab = $_GET['t'];
	
	echo '<div class="wrap">';
	echo '<h1 class="wp-heading-inline">GoAbroad HQ Plugin CRM</h1>';
	if ($tab=='f') { 
		$f = 'nav-tab-active';
	} elseif ($tab=='fg') {  
		$fg = 'nav-tab-active';
	} elseif ($tab=='ff') {  
		$ff = 'nav-tab-active';
	} elseif ($tab=='fas') {  
		$fas = 'nav-tab-active';
	} elseif ($tab=='fsl') {  
		$fsl = 'nav-tab-active';
	}
	echo '<h2 class="nav-tab-wrapper">
    <a href="?page=go_crm&t=f" class="nav-tab '.$f.'">Settings </a>';
	if (!empty(get_gocrm_settings("ApiUsername")) AND !empty(get_gocrm_settings("ApiKey"))) {
    echo '<a href="?page=go_crm&t=fg" class="nav-tab '.$fg.'">Form List</a>
    <a href="?page=go_crm&t=ff" class="nav-tab '.$ff.'">Form Fields </a>
    <a href="?page=go_crm&t=fas" class="nav-tab '.$fas.'">Form Available Selection </a>
	<a href="?page=go_crm&t=fsl" class="nav-tab '.$fsl.'">Form Submit Logs</a>
	';
	}
	echo '</h2>';
if ($tab=='fg') { 	
	echo '<div class="wrap">';
	echo '<h1 class="wp-heading-inline">Forms</h1><a href="?page=gocrmforms" class="page-title-action">Add New</a>';
	if (!empty($_GET['delete'])) { 
		if (gocrm_delete_record($_GET['delete'])) {
		echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Form has been Deleted. </p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
		} else { 
		echo "Something went wrong.";
		}
	}
	if (!empty($_GET['copy'])) { 
		if (gocrm_copy_record($_GET['copy'])) {
		echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Form has been copied. </p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
		} else { 
		echo "Something went wrong.";
		}
	}
	$fg = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."gocrm_form_group ");
	if ($fg) {
	echo '<table class="wp-list-table widefat fixed striped ">';
	echo '<thead><th>Group Name</th><th>Form Type</th><th>Shortcode</th><th>Action</th></thead><tbody>';
		foreach ($fg as $key => $row) {
	echo '<tr>
	<td>'.$row->group_name.'</td>
	<td>'.$row->form_type.'</td>
	<td>[gocrmforms formname="'.$row->group_name.'"]</td>
	<td>
	<a href="?page=gocrmforms&edit='.$row->id.'&name='.$row->group_name.'&ftype='.$row->form_type.'" title="Edit"  class="dashicons-before dashicons-admin-generic"></a>
	<a class="deletegroup dashicons-before dashicons-dismiss" title="Delete" href="?page=go_crm&t=fg&delete='.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this form?\')"></a>
	<a class="deletegroup dashicons-before dashicons-admin-page" title="Copy" href="?page=go_crm&t=fg&copy='.$row->id.'" ></a>
	</tr>';
		}
	echo '</tbody></table>';
	}
	echo '</div>';
} elseif ($tab=='fas') { 
	echo '<div class="wrap">';
	echo '<h1>Available Selection Dropdown</h1>';
	echo '<p>(This Fields Selection are from https://api.goabroadhq.com/API/GoAbroadHQ.svc/References.)</p>';
	echo '<table>';
	$availablefields = getgocrm_available_selection();
	$i=1;
	foreach ($availablefields  as $k => $v) { 
		echo '<tr><td>'.$i.'.</td><td>'.$k.'</td><td>';
		//var_dump($v->Countries->InnerNode);
		echo '<select name="'.$k.'">';
		foreach ($v as $nk => $nv) { 
			echo '<option value="'.$nv->attributes()->Id.'" >'.$nv[0].'</option>';
		}
		echo '</select></td>';
		echo '</tr>';
		$i++;
	}
	echo '</table>';
	echo '</div>';
} elseif ($tab=='ff') { 
	echo '<div class="wrap">';
	echo '<h1>Available Lead Fields</h1>';
	echo '<p>(This Fields are from https://hq-api.goabroadhq.com/schema/leads.)</p>';
	echo '<table>';
	$availablefields = getgocrm_available_lead_fields();
	$i=1;
	foreach ($availablefields  as $v) { 
		echo '<tr><td>'.$i.'.</td><td>'.$v.'</td></tr>';
		$i++;
	}
	echo '</table>';
	echo '<h1>Available Participants Fields</h1>';
	echo '<p>(This Fields are from https://hq-api.goabroadhq.com/schema/participants.)</p>';
	echo '<table>';
	$availablefields2 = getgocrm_available_part_fields();
	$i=1;
	foreach ($availablefields2  as $v) { 
		echo '<tr><td>'.$i.'.</td><td>'.$v.'</td></tr>';
		$i++;
	}
	echo '</table>';
	echo '</div>';
} elseif ($tab=='fsl') { 
	echo '<div class="wrap">';
	echo '<h1>Form Submit Logs</h1>';
	echo '<p>This are sbumit logs that was sent to HQ API</p>';
	echo '<table class="wp-list-table widefat fixed striped ">
		<thead>
			<tr>
				<td>ID</td>
				<td>Form Type</td>
				<td>IP FROM</td>
				<td>Date Submitted</td>
				<td>Data</td>
			</tr>
		</thead>
		<tbody>
	';
	$submitlogs = gocrm_submitlogs();
	$i=1;
	$data_k = "";
	$k = "";
	foreach ($submitlogs  as $v) { 
		$json_a = json_decode($v->json_data, true);
		foreach ($json_a  as $k => $vd) { 
			if ($k!="gtype") {
			$data_k .= $k ." : " . $vd . " <br />";
			}
		}
		echo '<tr>
			<td>'.$i.'</td>
			<td>'.ucfirst($json_a['gtype']).'</td>
			<td>'.$v->ip_from.'</td>
			<td>'.$v->dateadded.'</td>
			<td>'.
				$data_k
			.'</td></tr>
			';
		$i++;
	}
	echo '</tbody></table>';
	
} elseif ($tab=='fas') { 
	echo '<div class="wrap">';
	echo '<h1>Available Participants Fields</h1>';
	echo '<p>(This Fields are from https://hq-api.goabroadhq.com/schema/participants.)</p>';
	echo '<table>';
	$availablefields2 = getgocrm_available_part_fields();
	$i=1;
	foreach ($availablefields2  as $v) { 
		echo '<tr><td>'.$i.'.</td><td>'.$v.'</td></tr>';
		$i++;
	}
	echo '</table>';
	echo '</div>';
} else { 

	echo '<h1 class="wp-heading-inline">CRM Settings</h1>';
	if (!empty($_POST)) {
		gocrmupdate_settings(sanitize_text_field($_POST['ApiUsername']), sanitize_text_field($_POST['ApiKey']), sanitize_text_field($_POST['ApiOrgId']), sanitize_text_field($_POST['Status']));
		echo '<script>window.location.reload();</script>';
	}
	if (get_gocrm_settings("Status")=='Staging') {  
		$stagingstatus = "checked='checked'";
	} else { 
		$livestatus = "checked='checked'";
	}
	echo '
	<form method="post" action="?page=go_crm">
		<table class="form-table">
			<tr>
				<th scrope="row">
					<label for="HQ">HQ Username</label>
				</th>
				<td>
					<input name="ApiUsername" id="username" value="'.get_gocrm_settings("ApiUsername").'" class="regular-text code" type="text">
				</td>
			</tr>
			<tr>
				<th scrope="row">
					<label for="HQ">HQ API KEY</label>
				</th>
				<td>
					<input name="ApiKey" id="apikey" value="'.get_gocrm_settings("ApiKey").'" class="regular-text code" type="text">
				</td>
			</tr>
			<tr>
				<th scrope="row">
					<label for="HQ">HQ Org ID</label>
				</th>
				<td>
					<input name="ApiOrgId" id="username" value="'.get_gocrm_settings("ApiOrgId").'" class="regular-text code" type="text">
				</td>
			</tr>
			<tr>
				<th scrope="row">
					<label for="HQ">Status</label>
				</th>
				<td>
					Live <input name="Status" id="username" value="Live" class="regular-text code" type="radio" '.$livestatus.'>
					Staging <input name="Status" id="username" value="Staging" class="regular-text code" type="radio" '.$stagingstatus.'>
				</td>
			</tr>
		</table>
		<p class="submit"><input name="submit" id="submit" class="button button-primary" value="Save Changes" type="submit"></p>
	</form>
	';
}
	echo '</div>';
}

function gocrm_selectforms($formname) {
	global $wpdb; 
	$fn = $wpdb->get_results("SELECT DISTINCT ff.sort, ff.form_label,ff.form_name, fg.group_name, ft.form_type,  ft.form_select_match, ff.required, fg.form_type as gtype, (SELECT count(sort) cnt FROM ".$wpdb->prefix."gocrm_form_fields WHERE sort = ff.sort AND form_group_id = ff.form_group_id HAVING cnt > 1) as cnt  FROM ".$wpdb->prefix."gocrm_form_fields as ff LEFT JOIN ".$wpdb->prefix."gocrm_form_group as fg ON fg.id = ff.form_group_id LEFT JOIN ".$wpdb->prefix."gocrm_form_types as ft ON ft.form_field = ff.form_name WHERE fg.group_name = '".$formname."' ORDER BY sort ASC");
	
	echo '
	<label>'.$formname.'</label>';
	ob_start();
	$has_post = (!empty($_POST) ? true : false);
	$captcha_c = (!empty(sanitize_text_field($_POST['go_captcha'])) ? true : false);
	if ($captcha_c) { 
		$check_captcha = (sanitize_text_field($_POST['go_captcha'])==$_SESSION['captcha']['code'] ? true : false);
		if (!$check_captcha) { 
			$error = '<p style="color:red;">Captcha didnt matched.</p>';
		}
	}
	if ($has_post==true && $check_captcha==true) {
	check_admin_referer( 'gocrm_nonce_verify' );
	gocrm_send_form(json_encode($_POST), sanitize_text_field($_POST['gtype']));
	echo  "<p>Form has been submitted. Thank You.";
	} else {
		echo $error;
	echo '
		<form method="post" action="" id="gocrmform">
			<table>';
			echo "<tr>";
			$i=0;
		foreach ($fn as $key => $row) {
			$i++;
			$gtype = $row->gtype;
			?>
				<td>
					<label><?php echo $row->form_label; ?></label>
					<?php echo gocrm_create_form($row->form_name, $row->form_type, $row->required, $row->form_select_match);?>
				</td>
			<?php
			if ($row->cnt == NULL || $row->cnt == $i) {
			echo "</tr>";
			echo "<tr>";
			} 
			$s = $row->sort;
		}
	echo '
		<tr>
			<td >
			';
			$_SESSION['captcha'] = gocrmsimple_php_captcha();
			?>
			<label>Captcha </label>
			<p style="width:20%;float:left;"><img  style="float:left;" src="<?php echo $_SESSION['captcha']['image_src']; ?>"></p>
			<input name="go_captcha" type="text" style="width:80%;float:left;" required>
			<?php
	echo		'
			</td>
		</tr>
	';
	echo'		<tr>
		<td colspan="2" style="text-align:center;">
		<input type="hidden" name="gtype" value="'.$gtype.'" />
		<input type="submit" value="Submit"/>
		
		</td>
	</tr>
			</table>';
	wp_nonce_field( 'gocrm_nonce_verify');
	echo '</form>
	<script>
	$(document).ready(function(){
		$("#gocrmform").validate();
	});
	</script>
	';
	}
	$output = ob_get_clean();
	return $output;
}