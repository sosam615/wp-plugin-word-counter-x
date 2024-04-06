<?php
/*
Plugin Name: Word Counter x
Description: A simple WordPress plugin to count words in posts and pages.
Version: 0.1
Author: ASAF AI
*/

// Function to count words in content
function word_counter_count_words($content) {
    $word_count = str_word_count(strip_tags($content));
    return $word_count;
}

// Function to display word count in editor
function word_counter_display_word_count() {
    global $post;
    $content = $post->post_content;
    $word_count = word_counter_count_words($content);
    ?>
    <script>
        jQuery(document).ready(function($) {
            $('#post-status-info').append('<span id="word-count">Word count: <?php echo $word_count; ?></span>');
        });
    </script>
    <?php
}

// Hook to add word count display to editor
add_action('edit_form_after_title', 'word_counter_display_word_count');

// Function to display word count in admin bar
function word_counter_admin_bar_menu($wp_admin_bar) {
    if (is_admin()) {
        global $post;
        if ($post && !empty($post->post_content)) {
            $word_count = word_counter_count_words($post->post_content);
            $args = array(
                'id' => 'word-count-admin-bar',
                'title' => 'Word Count: ' . $word_count,
                'meta' => array(
                    'class' => 'word-count-admin-bar',
                    'title' => 'Word Count: ' . $word_count,
                ),
            );
            $wp_admin_bar->add_node($args);
        }
    }
}

// Hook to add word count to admin bar
add_action('admin_bar_menu', 'word_counter_admin_bar_menu', 999);

?>