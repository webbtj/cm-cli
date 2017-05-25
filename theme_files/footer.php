<?php
$smarty = wp_smarty();

$contact_title = get_field('contact_title', 'options');
$smarty->assign('contact_title', $contact_title);

$address_title = get_field('address_title', 'options');
$smarty->assign('address_title', $address_title);

$contact_address = get_field('contact_address', 'options');
$smarty->assign('contact_address', $contact_address);

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
