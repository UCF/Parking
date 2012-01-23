<?php
$page   = get_page_by_path('shuttles');
$content  = $page->post_content;
$content  = apply_filters('the_content', $content);
$content  = str_replace(']]>', ']]>', $content);

// clean up classes and remove images
$content  = preg_replace('/\s?class="[^"]+"/', '', $content);
$content  = preg_replace('/<img[^>]+>/', '', $content);

$content  = preg_replace('/href="\//', 'href="'.get_bloginfo('url').'/', $content);

echo $content;