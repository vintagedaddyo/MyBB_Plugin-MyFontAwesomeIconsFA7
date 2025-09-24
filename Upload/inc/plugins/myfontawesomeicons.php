<?php
/*
 * MyBB: MyFontAwesomeIcons FA7
 *
 * File: myfontawesomeicons.php
 *
 * Authors: Ethan DeLong & Vintagedaddyo
 *
 * MyBB Version: 1.8
 *
 * Plugin Version: 1.0
 *
 */

// Disallow direct access to this file for security reasons

if(!defined("IN_MYBB"))
{
    die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

// Admin settings injection

$plugins->add_hook("admin_formcontainer_output_row", "myfontawesomeicons_admin_settings");
$plugins->add_hook("admin_forum_management_add_commit", "myfontawesomeicons_admin_settings_save");
$plugins->add_hook("admin_forum_management_edit", "myfontawesomeicons_admin_settings_save");

// Inject creation of forum row.

$plugins->add_hook("build_forumbits_forum", "myfontawesomeicons_display_icons");

function myfontawesomeicons_info()
{
    global $lang;

    $lang->load("forum_management_myfontawesomeicons");

    $lang->myfontawesomeicons_Desc = '<form target="_blank" action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;">' .
        '<input type="hidden" name="cmd" value="_s-xclick">' .
        '<input type="hidden" name="hosted_button_id" value="AZE6ZNZPBPVUL">' .
        '<input type="image" src="../inc/plugins/myfontawesomeicons/donate/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">' .
        '<img alt="" border="0" src="../inc/plugins/myfontawesomeicons/donate/pixel.gif" width="1" height="1">' .
        '</form>' . $lang->myfontawesomeicons_Desc;

    return Array(
        'name' => $lang->myfontawesomeicons_Name,
        'description' => $lang->myfontawesomeicons_Desc,
        'website' => $lang->myfontawesomeicons_Web,
        'author' => $lang->myfontawesomeicons_Auth,
        'authorsite' => $lang->myfontawesomeicons_AuthSite,
        'version' => $lang->myfontawesomeicons_Ver,
        'compatibility' => $lang->myfontawesomeicons_Compat
    );
}

function myfontawesomeicons_install()
{
    global $db;
    
    //$db->add_column('forums', 'myfontawesomeicons_icon', 'TEXT NOT NULL');

    // Define an initial default icon

    $db->add_column('forums', 'myfontawesomeicons_icon', 'varchar(32) DEFAULT "fa-solid fa-comments"');
}

function myfontawesomeicons_is_installed()
{
	global $db;

	return $db->field_exists('myfontawesomeicons_icon', 'forums');
}

function myfontawesomeicons_uninstall()
{
	global $db;

	$db->drop_column('forums', 'myfontawesomeicons_icon');
}

function myfontawesomeicons_activate()
{
    require_once MYBB_ROOT."inc/adminfunctions_templates.php";

    $old1 = "<span class=\"forum_status forum_{\$lightbulb['folder']} ajax_mark_read\" title=\"{\$lightbulb['altonoff']}\" id=\"mark_read_{\$forum['fid']}\"></span>";

    $new1 = "<div class=\"forum_status forum_{\$lightbulb['folder']} ajax_mark_read\" title=\"{\$lightbulb['altonoff']}\" id=\"mark_read_{\$forum['fid']}\"><i class=\"{\$forum['myfontawesomeicon']}\"></i></div>";

    find_replace_templatesets("forumbit_depth2_forum", "#".preg_quote($old1)."#i", "$new1");
    find_replace_templatesets("forumbit_depth2_cat", "#".preg_quote($old1)."#i", "$new1");

    $old2 = "<div title=\"{\$lightbulb['altonoff']}\" class=\"subforumicon subforum_{\$lightbulb['folder']} ajax_mark_read\" id=\"mark_read_{\$forum['fid']}\"></div>";

    $new2 = "<div title=\"{\$lightbulb['altonoff']}\" class=\"subforumicon subforum_{\$lightbulb['folder']} ajax_mark_read\" id=\"mark_read_{\$forum['fid']}\"><i class=\"{\$forum['myfontawesomeicon']}\"></i></div>";

    find_replace_templatesets("forumbit_depth3_statusicon", "#".preg_quote($old2)."#i", "$new2");

    find_replace_templatesets("headerinclude", '#{\$stylesheets}(\r?)\n#', "{\$stylesheets}\n<link href=\"{\$mybb->asset_url}/inc/plugins/myfontawesomeicons/font-awesome-7/css/all.css\" rel=\"stylesheet\" type=\"text/css\">\n");

	global $db;

    $stylesheet = '.forum_status {background: none !important;height: 50px !important;width: 50px !important;font-size: 30px !important;text-align: center !important;}
.forum_status i {display: inline-block !important;line-height: 50px !important;}
.forum_on {color: #0094d1 !important;}
.forum_on i
.forum_off, .forum_offclose, .forum_offlink {color: #333 !important;}
.forum_off i {opacity: .4 !important;}
/*.forum_offclose i:before {content: "";}*/
/*.forum_offlink i:before {content: "";}*/
.subforumicon {background: none !important; height: 10px !important;width: 10px !important;display: inline-block !important;margin: 0 5px !important;}
.subforum_minion {color: #0094d1 !important;}
.subforum_minioff, .subforum_minioffclose, .subforum_miniofflink {color: #333 !important;}
.subforum_minioff {opacity: .4 !important;}
/*.subforum_minioffclose i:before {content: "";}*/
/*.subforum_miniofflink i:before {content: "";}*/
.forum_legend, .forum_legend dt, .forum_legend dd {margin: 0 !important;padding: 0 !important;}
.forum_legend dd {float: left !important;margin-right: 10px !important;margin-top: 17px !important;}
.forum_legend dt {float: left !important;margin-right: 5px !important;}';

    $new_stylesheet = array(
        'name'         => 'myfontawesomeicons.css',
        'tid'          => 1,
        'attachedto'   => '',
        'stylesheet'   => $stylesheet,
        'lastmodified' => TIME_NOW
    );

    $sid = $db->insert_query('themestylesheets', $new_stylesheet);

    $db->update_query('themestylesheets', array('cachefile' => "css.php?stylesheet={$sid}"), "sid='{$sid}'", 1);

    $query = $db->simple_select('themes', 'tid');

    while($theme = $db->fetch_array($query))
    {
        require_once MYBB_ADMIN_DIR.'inc/functions_themes.php';

        update_theme_stylesheet_list($theme['tid']);
    }
}

function myfontawesomeicons_deactivate()
{
    require_once MYBB_ROOT."inc/adminfunctions_templates.php";

    $new1 = "<span class=\"forum_status forum_{\$lightbulb['folder']} ajax_mark_read\" title=\"{\$lightbulb['altonoff']}\" id=\"mark_read_{\$forum['fid']}\"></span>";

    $old1 = "<div class=\"forum_status forum_{\$lightbulb['folder']} ajax_mark_read\" title=\"{\$lightbulb['altonoff']}\" id=\"mark_read_{\$forum['fid']}\"><i class=\"{\$forum['myfontawesomeicon']}\"></i></div>";

    find_replace_templatesets("forumbit_depth2_forum", "#".preg_quote($old1)."#i", "$new1");
    find_replace_templatesets("forumbit_depth2_cat", "#".preg_quote($old1)."#i", "$new1");

    $new2 = "<div title=\"{\$lightbulb['altonoff']}\" class=\"subforumicon subforum_{\$lightbulb['folder']} ajax_mark_read\" id=\"mark_read_{\$forum['fid']}\"></div>";

    $old2 = "<div title=\"{\$lightbulb['altonoff']}\" class=\"subforumicon subforum_{\$lightbulb['folder']} ajax_mark_read\" id=\"mark_read_{\$forum['fid']}\"><i class=\"{\$forum['myfontawesomeicon']}\"></i></div>";

    find_replace_templatesets("forumbit_depth3_statusicon", "#".preg_quote($old2)."#i", "$new2");

    find_replace_templatesets("headerinclude", '#<link href=\"{\$mybb->asset_url}/inc/plugins/myfontawesomeicons/font-awesome-7/css/all.css\" rel=\"stylesheet\" type=\"text/css\">(\r?)\n#', "", 0);

	global $db;

    $db->delete_query('themestylesheets', "name='myfontawesomeicons.css'");

    $query = $db->simple_select('themes', 'tid');

    while($theme = $db->fetch_array($query))
    {
        require_once MYBB_ADMIN_DIR.'inc/functions_themes.php';

        update_theme_stylesheet_list($theme['tid']);
    }
}

function myfontawesomeicons_display_icons($forum)
{
	global $theme;

	if(!empty($forum['myfontawesomeicons_icon']))
	{
		$icon_path = str_replace("{theme}", $theme['imgdir'], $forum['myfontawesomeicons_icon']);

		$forum['myfontawesomeicon'] = htmlspecialchars_uni("{$icon_path}");
	}

	return $forum;
}

function myfontawesomeicons_admin_settings(&$pluginargs)
{
	global $form, $form_container, $forum_data, $lang, $mybb;

	if($mybb->input['module'] == 'forum-management')
	{
		if($pluginargs['title'] == $lang->display_order)
		{
			$lang->load('forum_management_myfontawesomeicons');

            if(empty($forum_data['myfontawesomeicons_icon']))
            {
                // display suggested icon in input if empty
                $forum_data['myfontawesomeicons_icon'] = "fa-solid fa-comments";
            }                
                
    		$form_container->output_row($lang->myfontawesomeicons_forum_icons, $lang->myfontawesomeicons_forum_icons_desc, $form->generate_text_box('myfontawesomeicons_icon', $forum_data['myfontawesomeicons_icon'], array('id' => 'myfontawesomeicons_icon')));
		}
	}
}

function myfontawesomeicons_admin_settings_save()
{
	global $db, $fid, $mybb;

	if($mybb->request_method == "post")
	{
		$db->update_query("forums", array("myfontawesomeicons_icon" => $db->escape_string($mybb->input['myfontawesomeicons_icon'])), "fid='{$fid}'");
	}
}

?>