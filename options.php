<?php

add_action('admin_menu', 'rlink_upcoming_menu');

function rlink_upcoming_menu() 
{
  add_options_page('Upcoming Options', 'Upcoming Events', 8, __FILE__, 'rlink_upcoming_options');
}

function rlink_upcoming_options() 
{
	global $upcomingEvents_pluginroot;
?>

<div id="themeCSS"/>

<div class="wrap">
<h2>Usage</h2>
<p>
To display a list of upcoming events on a page or post, do the following:
</p>
<ol style="list-style-position:inside;list-style-type: decimal;">
<li>Add a custom field entitled "UpcomingEvent" to the post which represents the upcoming event. Enter
a date as "January 25th 2009" or "3pm May 14 2012". Full input format specs <a target="_blank" href="http://www.php.net/strtotime">
Here</a>.</li>
<li>Insert [UpcomingEvents] into the post or page you want the list displayed</li>
</ol>
<p>
Only events happening today or in the future will be displayed. Date output format specs can be found <a target="_blank"
href="http://www.php.net/manual/en/function.date.php">Here</a>.
</p>

<h2>Upcoming Event Options</h2>


<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">

<tr>
<td>Title</td>
<td>
<table>
<tr>
<td><input id="upcoming_title" name="upcoming_title" type="text" value="<?php echo rlink_upcoming_title(); ?>" /></td>
<td>(Enter '&lt;hide&gt;' to hide the title box)</td>
</tr>
</table>
</td>
</tr>

<tr>
<td>Date/Time Format</td>
<td>
<table>
<tr>
<td><input id="upcoming_date_format" name="upcoming_date_format" type="text" value="<?php echo rlink_upcoming_date_format(); ?>" /></td>
<td>(To show time of day, etc. see <a target="_blank" href="http://www.php.net/manual/en/function.date.php">Format Specs</a>. Save as blank to restore default)</td>
</tr>
</table>
</td>
</tr>

<tr valign="top">
<td scope="row">Style</td>
<td>
<textarea id="styleText" name="upcoming_styles" rows="20" cols="80">
<?php
echo rlink_upcoming_get_styles();
?>
</textarea>
</td>
</tr>

<tr>
<td scope="row">Event Item HTML</td>
<td>Variables: %time%, %post_id%, %title%, %desc%</td>
</tr>

<tr>
<td></td>
<td>
<textarea id="itemHTML" name="upcoming_event_item" rows="5" cols="80">
<?php
echo rlink_upcoming_event_item();
?>
</textarea>
</td>
</tr>
 
</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="upcoming_title,upcoming_date_format,upcoming_styles,upcoming_event_item" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>

</div>

<?php
}

?>