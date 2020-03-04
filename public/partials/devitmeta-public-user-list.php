<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://itnotes.org.ua/
 * @since      1.0.0
 *
 * @package    Devitmeta
 * @subpackage Devitmeta/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h3 class="entry-title">User list:</h3><ul>
<?php    foreach( $templates_var['users'] as $user ){ ?>
    <li><a href="?user_info=<?php echo $user->ID; ?>"><?php echo $user->user_login; ?></li>
<?php    } ?>
</ul>
<?php echo $templates_var['pagination']; ?>