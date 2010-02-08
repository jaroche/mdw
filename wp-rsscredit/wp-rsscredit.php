<?php
/*
Plugin Name: Creditos extras en el feed
Plugin URI: http://www.maestrosdelweb.com/editorial/pugin-wordpress-muchos-autores-creditos-feed/
Description: Agrega creditos adicionales para el autor, al final de cada post en el feed del blog
Version: 0.1
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

/* Si ya se está usando el plugin de Author Image (http://wordpress.org/extend/plugins/sem-author-image/), se usaran esos avatars*/

$default  = ''; // URL a la imagen a mostar en caso de no encontrar una con gravatar. En blanco usa la de Gravatar.

function get_author_avatar() {
	global $default;

	$avatar = '';
	if ( class_exists('author_image') )
		$avatar = author_image::get();
	
	if ( $avatar == '' ) {
		if ( in_the_loop() ) {
			$author_id = get_the_author_ID();
		} elseif ( is_singular() ) {
			global $wp_the_query;
			$author_id = $wp_the_query->posts[0]->post_author;
		} elseif ( is_author() ) {
			global $wp_the_query;
			$author_id = $wp_the_query->get_queried_object_id();
		}
		
		$author = get_userdata($author_id);
		if ( !empty($author) ) 
			$avatar = get_avatar( $author->user_email, 64, $default , $author->display_name );
		else
			$avatar = '<img src="' . esc_url($default) . '" alt="' . $author->display_name .'" />';
	}
	
	return $avatar;
}

function author_avatar() 
{
	echo get_author_avatar();
}

function rss_extracredit($content) {
	if(!is_feed()) return $content;
	
	$avatar = str_replace( ' />' , ' style="float:left;padding:0 5px" />', get_author_avatar() );
		
	$author = get_the_author();
	$permalink = get_permalink();

		
	$content .= "<hr /><p>$avatar <strong>$author</strong> para <a href=\"" . get_bloginfo('url'). '">'.get_bloginfo('name'). '.<br />'
	."<a href=\"$permalink#respond\">Agrega tu comentario</a> | <a href=\"$permalink\">Enlace permanente</a> al art&iacute;culo</p>";
	
	return $content;
}

add_filter('the_content', 'rss_extracredit');