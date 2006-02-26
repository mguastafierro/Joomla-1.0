<?php
/**
* @version $Id$
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

$showmode 	= $params->get( 'showmode' );

$content 	= '';

if ($showmode==0 || $showmode==2) {
	$query = "SELECT guest, usertype"
	. "\n FROM #__session"
	;
	$database->setQuery( $query );
	$sessions = $database->loadObjectList();

	$user_array 	= 0;
	$guest_array 	= 0;
	foreach( $sessions as $session ) {
		if ( $session->guest == 1 && !$session->usertype ) {
			$guest_array++;
		}
		if ( $session->guest == 0 ) {
			$user_array++;
		}
	}

	if ($guest_array != 0 && $user_array==0) {
		if ($guest_array==1) {
			$content.=_WE_HAVE;
			$content.=_GUEST_COUNT;
			$content.=_ONLINE;
			eval ("\$content = \"$content\";");
		} else {
			$content.=_WE_HAVE;
			$content.=_GUESTS_COUNT;
			$content.=_ONLINE;
			eval ("\$content = \"$content\";");
		}
	}

	if ($guest_array==0 && $user_array != 0) {
		if ($user_array==1) {
			$content.=_WE_HAVE;
			$content.=_MEMBER_COUNT;
			$content.=_ONLINE;
			eval ("\$content = \"$content\";");
		} else {
			$content.=_WE_HAVE;
			$content.=_MEMBERS_COUNT;
			$content.=_ONLINE;
			eval ("\$content = \"$content\";");
		}
	}

	if ($guest_array != 0 && $user_array != 0) {
		if ($guest_array==1) {
			$content.=_WE_HAVE;
			$content.=_GUEST_COUNT;
			$content.=_AND;
			eval ("\$content = \"$content\";");
		} else {
			$content.=_WE_HAVE;
			$content.=_GUESTS_COUNT;
			$content.=_ONLINE;
			$content.=_AND;
			eval ("\$content = \"$content\";");
		}

		if ($user_array==1) {
			$content.=_MEMBER_COUNT;
			$content.=_ONLINE;
			eval ("\$content = \"$content\";");
		} else {
			$content.=_MEMBERS_COUNT;
			$content.=_ONLINE;
			eval ("\$content = \"$content\";");
		}

	}
}

if ($showmode==1 || $showmode==2) {
	$query = "SELECT DISTINCT a.username"
	."\n FROM #__session AS a"
	."\n WHERE a.guest = 0"
	;
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	$content .= "<ul>\n";
	foreach($rows as $row) {
		$content .= "<li><strong>" . $row->username . "</strong></li>\n";
	}
	$content .= "</ul>\n";

	if ( !$content ) {
		echo _NONE ."\n";
	}
}
?>