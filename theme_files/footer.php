<?php
$smarty = wp_smarty();

$contact_title = get_field('contact_title', 'options');
$smarty->assign('contact_title', $contact_title);

$address_title = get_field('address_title', 'options');
$smarty->assign('address_title', $address_title);

$contact_address = get_field('contact_address', 'options');
$smarty->assign('contact_address', $contact_address);

$secure_link = get_field('secure_link', 'options');
$smarty->assign('secure_link', $secure_link);

$secure_link_url = get_field('secure_link_url', 'options');
$smarty->assign('secure_link_url', $secure_link_url);

$secure_link_name = get_field('secure_link_name', 'options');
$smarty->assign('secure_link_name', $secure_link_name);

$secure_link_image = get_field('secure_link_image', 'options');
$smarty->assign('secure_link_image', $secure_link_image);

$privacy_policy_page = get_field('privacy_policy_page', 'options');
if($privacy_policy_page){
    $privacy_policy_page->url = get_permalink($privacy_policy_page->ID);
    $smarty->assign('privacy_policy_page', $privacy_policy_page);
}

$smarty->display('includes/footer.tpl');

wp_footer();
?>
  </body>
</html>
