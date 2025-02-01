<?php


$post_title = get_the_title();
$post_url   = urlencode(get_permalink());

$encoded_title = urlencode($post_title);
$encoded_url   = urlencode($post_url);

$whatsapp_share_link = 'https://wa.me/?text=' . $encoded_title . ' - ' . $encoded_url;
$twitter_share_link  = 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_url;
$facebook_share_link = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
$email_share_link    = 'mailto:?subject=' . $post_title . '&body=' . $post_title . ' - ' . $post_url;
?>
<div class="data-share">
    <div class="data-share-label">
        Share:
    </div>

    <ul class="data-share-links">
        <li class="data-share-links-item">
            <a href="<?php echo $whatsapp_share_link; ?>" target="_blank">
                <?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/share/whatsapp.svg', false); ?>
            </a>

        </li>

        <li class="data-share-links-item">
            <a href="<?php echo $twitter_share_link; ?>" target="_blank">
                <?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/share/twitter.svg', false); ?>
            </a>
        </li>

        <li class="data-share-links-item">
            <a href="<?php echo $facebook_share_link; ?>" target="_blank">
                <?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/share/facebook.svg', false); ?>
            </a>
        </li>

        <li class="data-share-links-item">
            <a href="<?php echo $email_share_link; ?>">
                <?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/share/mailto.svg', false); ?>
            </a>
        </li>
    </ul>
</div>