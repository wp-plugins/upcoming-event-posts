<?php
/*  Copyright 2009  R-Link Research and Consulting, Inc.  (email : zach@rlinkconsulting.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*
Plugin Name: Upcoming Event Posts
Plugin URI: http://www.codezach.com
Description: 
Version: 0.1
Author: R-Link Research and Consulting, Inc.
Author URI: http://www.rlinkconsulting.com
*/

//**************************************************************
// Globals
//**************************************************************
global $upcomingEvents_pluginroot;

$upcomingEvents_rootdir = dirname(dirname(dirname(dirname(__FILE__))));
$upcomingEvents_pluginroot = dirname(__FILE__);
$upcomingEvents_webdir = '/wp-content/plugins/' . basename($upcomingEvents_pluginroot);

$upcomingEvents;

//**************************************************************
// Options
//**************************************************************

//--------------------------------------------------------------
// Get event item html
//--------------------------------------------------------------
function rlink_upcoming_event_item()
{
	$opt = get_option('upcoming_event_item');
	
	if(isset($opt) == false || $opt == false || strlen($opt) < 1)
	{
		$opt = "<li>\n<span class=\"upcomingEventTime\">%time%</span>\n" .
			"<span class=\"upcomingEventTitle\"><a href=\"/?p=%post_id%\">%title%</a></span>\n" .
			"<span class=\"upcomingEventDesc\">%desc%</span>\n</li>";
	}
	
	return $opt;
}

//--------------------------------------------------------------
// Get date format
//--------------------------------------------------------------
function rlink_upcoming_date_format()
{
	$format = get_option('upcoming_date_format');
	
	if(isset($format) == false || $format == false || strlen($format) < 1)
	{
		$format = "l jS F 'y";
	}
	
	return $format;
}

//--------------------------------------------------------------
// Get title
//--------------------------------------------------------------
function rlink_upcoming_title()
{
	$title = get_option('upcoming_title');
	
	if(isset($title) == false || $title == false || strlen($title) < 1)
	{
		$title = 'Upcoming Events';
	}
	
	return $title;
}

//--------------------------------------------------------------
// Get styles
//--------------------------------------------------------------
function rlink_upcoming_get_styles()
{
	global $upcomingEvents_pluginroot;
	
	$styles = get_option('upcoming_styles');
	
	if(isset($styles) == false || $styles == false || strlen($styles) < 1)
	{
		$styles = file_get_contents($upcomingEvents_pluginroot . '/defaultStyles.css');
	} 
	
	return $styles;
}

//**************************************************************
// Includes
//**************************************************************
$include = $upcomingEvents_pluginroot . '/options.php';
require_once $include;

//**************************************************************
// Initialize
//**************************************************************
add_action('wp_head', 'rlink_upcoming_do_head');
add_filter('the_content', 'rlink_upcoming_do_content');

//--------------------------------------------------------------
// Header
//--------------------------------------------------------------
function rlink_upcoming_do_head()
{
	echo '<style>';
	echo rlink_upcoming_get_styles();
	echo '</style>';
}

//--------------------------------------------------------------
// Compare events by date
//--------------------------------------------------------------
function rlink_event_compare($a, $b)
{
	if($a['date'] > $b['date'])
	{
		return 1;
	}
	
	if($a['date'] == $b['date'])
	{
		return 0;
	}
	
	return -1;
}

//--------------------------------------------------------------
// Content
//--------------------------------------------------------------
function rlink_upcoming_do_content($content)
{
	global $upcomingEvents, $upcomingEvents_pluginroot, $upcomingEvents_webdir;
	
	$posts = get_posts('meta_key=UpcomingEvent');
	
	$now = time();
	
	$upcomingEvents = array();
	
	foreach($posts as $post)
	{
		$meta = get_post_meta($post->ID, "UpcomingEvent", true);
		
		$date = strtotime($meta);
		
		if($date < $now)
		{
			continue;
		}
		
		$desc = $post->post_excerpt;
		
		if(strlen($desc) > 100)
		{
			$desc = substr($desc, 0, 100) . '...';
		}
		
		$event['id'] = $post->ID;
		$event['date'] = $date;
		$event['title'] = $post->post_title;
		$event['desc'] = $desc;
		
		$upcomingEvents[] = $event;
	}
	
	if(count($upcomingEvents) < 1)
	{
		return $ret;
	}
	
	usort($upcomingEvents, 'rlink_event_compare');
	
	$ret = preg_replace_callback( '/\[UpcomingEvents\]/',"rlink_upcoming_cb", $content);
	
	return $ret;
}

//--------------------------------------------------------------
// Match callback
//--------------------------------------------------------------
function rlink_upcoming_cb($matches)
{
	global $upcomingEvents_rootdir, $upcomingEvents;
		
	$ret = '<div class="upcomingEvents">';
	
	$title = rlink_upcoming_title();
	
	if($title != '<hide>')
	{
		$ret .= '<div class="upcomingEventsTitleBox"><p>' . $title . '</p></div>';
	}
	
	$ret .= '<ul>';
	
	$template = rlink_upcoming_event_item();
	
	foreach($upcomingEvents as $event)
	{
		$displayTime = date(rlink_upcoming_date_format(), $event['date']);
		
		$item = str_replace('%time%', $displayTime, $template);
		$item = str_replace('%post_id%', $event['id'], $item);
		$item = str_replace('%title%', $event['title'], $item);
		$item = str_replace('%desc%', $event['desc'], $item);
		
		$ret .= $item;
	}
	
	$ret .= '</ul></div>';
	
	return $ret;
}


?>