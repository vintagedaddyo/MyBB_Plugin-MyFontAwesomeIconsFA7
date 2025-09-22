MyFontAwesomeIcons FA7

Lets you implement custom Font-Awesome 7 icons for your forums.

Created by Ethan DeLong & Vintagedaddyo

This is a highly modified version of the plugin: MyForumIcons - Custom Forum Icons by Ethan DeLong

Specifically modified by Vintagedaddyo for Font-Awesome 7 implementation after several user requests for something of the sort.


This will allow you to add custom Font-Awesome 7 icons for your forums.


You can specify a css name to your forum's custom font-awesome 7 icon by going to the ACP => Forum Management => Edit Forum.



9/21/25 Current font awesome library included to: fontawesome free 7.0.1



localization support:

-english 
-englishgb
-espanol
-french
-italiano


What is new in version 1.0?


- updated font awesome version to 7 ie: 7.0.1 (initially)



To Install:

1) Upload The Files, And Go to Admin CP And Activate it!

2) Edit Index template: (Optional *) 


Home » Template Sets » Default Templates » Edit Template: index

* this was removed from auto install in previous versions of plugin for fa4 and fa5 for example as plenty of folks use themes that opt to not have forum icons under board stats on index and made more sense to now have this as an optional manual edit.

find:

{$boardstats}

<dl class="forum_legend smalltext">
	<dt><span class="forum_status forum_on" title="{$lang->new_posts}"></span></dt>
	<dd>{$lang->new_posts}</dd>

	<dt><span class="forum_status forum_off" title="{$lang->no_new_posts}"></span></dt>
	<dd>{$lang->no_new_posts}</dd>

	<dt><span class="forum_status forum_offclose" title="{$lang->forum_closed}"></span></dt>
	<dd>{$lang->forum_closed}</dd>

	<dt><span class="forum_status forum_offlink" title="{$lang->forum_redirect}"></span></dt>
	<dd>{$lang->forum_redirect}</dd>
</dl>
<br class="clear" />


replace with:

{$boardstats}

<dl class="forum_legend smalltext">
  <dt><div class="forum_status forum_on" title="{$lang->new_posts}"><i class="fa-solid fa-comments"></i></div></dt>
  <dd>{$lang->new_posts}</dd>

  <dt><div class="forum_status forum_off" title="{$lang->no_new_posts}"><i class="fa-solid fa-comments"></i></div></dt>
  <dd>{$lang->no_new_posts}</dd>

  <dt><div class="forum_status forum_offclose" title="{$lang->forum_closed}"><i class="fa-solid fa-lock"></i></div></dt>
  <dd>{$lang->forum_closed}</dd>

  <dt><div class="forum_status forum_offlink" title="{$lang->forum_redirect}"><i class="fa-solid fa-link"></i></div></dt>
  <dd>{$lang->forum_redirect}</dd>
</dl>
<br class="clear" />



3) Go to forums Management Edit Forum Settings and edit each forum with your specific Font Awesome Icon.

The CSS name for the font awesome icon. For example: fa-solid fa-comments

You can specify a css name to your forum's custom font-awesome icon by going to the ACP => Forum Management => Edit Forum.


Final note for existing themes that have font-awesome already installed:

If your theme has custom forumbit template modifications ie: forumbit_depth2_cat, forumbit_depth2_forum, forumbit_depth3_statusicon you will need to revert those templates to default before installing the plugin and also remove any other font-awesome include say for example in headerinclude if already present in the theme. if you don't revert them you would have to manually insert the plugin calls.

mainly what you need to find is where to add the plugin calls for example:

In forumbit_depth2_forum & forumbit_depth2_cat & forumbit_depth3_statusicon you would find:


id="mark_read_{$forum['fid']}">



And add this after:


<i class="{$forum['myfontawesomeicon']}"></i>


In headerinclude template you would also need to make sure that after:


{$stylesheets}


There is the following include:

<link href="{$mybb->asset_url}/inc/plugins/myfontawesomeicons/font-awesome-7/css/all.css" rel="stylesheet" type="text/css">



And that your font awesome include in that template or wherever it is included is commented

<!-- -->

out so as to avoid version conflicts.