<?php
$post_id = get_the_ID();
$user_id = get_current_user_id();
$user_favorites = get_user_meta($user_id, '_user_favorites', true);
$favorited = $user_favorites ? in_array($post_id, $user_favorites) : false;
// mi_debug($favorited);
?>
<form class="mi-toggle-favorite form-contact" role="search" action="' . esc_url(admin_url('admin-post.php')) . '" method="post" id="mi-toggle-favorite">
    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input type="hidden" name="mi_toggle_favorite_form_nonce" value="<?php echo wp_create_nonce('mi_toggle_favorite_form_nonce') ?>" />
    <input type="hidden" name="action" value="mi_toggle_favorite_form">
    <button type="submit" class="item favorite-link <?php echo $favorited ? 'favorited' : ''; ?>">
        <svg class="icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.75 6.1875C15.75 4.32375 14.1758 2.8125 12.234 2.8125C10.7828 2.8125 9.53625 3.657 9 4.86225C8.46375 3.657 7.21725 2.8125 5.76525 2.8125C3.825 2.8125 2.25 4.32375 2.25 6.1875C2.25 11.6025 9 15.1875 9 15.1875C9 15.1875 15.75 11.6025 15.75 6.1875Z" stroke="#A3ABB0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
</form>