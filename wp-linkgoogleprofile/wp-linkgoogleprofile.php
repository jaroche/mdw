<?php
/*
Plugin Name: Enlaza al perfil de google
Plugin URI: http://www.maestrosdelweb.com/editorial/conectar-sitios-google-buzz-social-graph-api/
Description: Enlaza al perfil de google desde la página del autor
Version: 0.2
Author: Javier Aroche
Author URI: http://www.maestrosdelweb.com
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


function profilelink()
{
	global $wp_query;
	
	if ( !$wp_query->is_author ) return;
	
	$author = $wp_query->get_queried_object();
	$gtalk = get_the_author_meta( 'jabber', $author->ID );
	if ( !empty($gtalk) ) {
		$parts = explode( '@', $gtalk, 2);
	
		if ( isset( $parts[0] ) ): ?>
		<link rel="me" type="text/html" href="http://www.google.com/profiles/<?=esc_attr($parts[0])?>"/>
		<? endif;
	}
}

add_action('wp_head', 'profilelink' );