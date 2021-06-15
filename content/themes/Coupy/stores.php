<?php

$types              = array();
$types['all']       = array('label' => t('theme_all_stores', 'All Stores'),  'url' => get_remove(array('page', 'type', 'firstchar', 'cid', 'pid')),                                                'orderby' => 'name',        'firstchar' => true,    'show' => '');
$types['top']       = array('label' => t('theme_top_stores', 'Top Stores'),  'url' => get_update(array('type' => 'top'), get_remove(array('page', 'type', 'firstchar', 'cid', 'pid'))),        'orderby' => 'rating desc', 'firstchar' => false,   'show' => '',       'limit' => 50);
$types['most-voted'] = array('label' => t('theme_most_voted', 'Most Voted'),  'url' => get_update(array('type' => 'most-voted'), get_remove(array('page', 'type', 'firstchar', 'cid', 'pid'))), 'orderby' => 'votes desc',  'firstchar' => false,   'show' => '',       'limit' => 50);
$types['popular']   = array('label' => t('theme_most_popular', 'Popular'),   'url' => get_update(array('type' => 'popular'), get_remove(array('page', 'type', 'firstchar', 'cid', 'pid'))),    'orderby' => 'votes desc',  'firstchar' => false,   'show' => 'popular', 'limit' => 50);

$type = isset($_GET['type']) && in_array($_GET['type'], array_keys($types)) ? $_GET['type'] : 'all';

$atts = array();

if (isset($_GET['firstchar']) && $types[$type]['firstchar']) {
    $atts['firstchar'] = substr($_GET['firstchar'], 0, 1);
}

$atts['show'] = $types[$type]['show'];

if (isset($types[$type]['limit'])) {
    $atts['limit'] = $types[$type]['limit'];
}

have_items($atts);
?>

<div class="page-intro">
    <div class="page-intro-content">
        <h1><?php te('stores', 'Stores'); ?></h1>
        <ul class="button-set">
            <?php foreach ($types as $type_id => $type_nav) {
                echo '<li' . ($type_id == $type ? ' class="selected"' : '') . '><a href="' . $type_nav['url'] . '">' . $type_nav['label'] . '</a></li>';
            } ?>
        </ul>
    </div>
</div>

<?php if ($types[$type]['firstchar']) { ?>

    <div class="bg-gray">
        <div class="container pt25 pb25">
            <div class="row">
                <div class="col-md-12">
                    <div class="letters-container">
                        <ul class="letters text-center">
                            <?php foreach ((range('A', 'Z') + array(27 => '0-9'))  as $char) {
                                echo '<li' . (isset($_GET['firstchar']) && $_GET['firstchar'] == $char ? ' class="selected"' : '') . '><a href="' . get_update(array('firstchar' => $char), tlink('stores')) . '">' . $char . '</a></li>';
                            }
                            echo '<li><a href="' . get_remove(array('firstchar', 'cid', 'pid')) . '">' . t('theme_all', 'All') . '</a></li>'; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<div class="container pt50 pb50">

    <?php if (results()) {
        echo '<div class="row">';
        foreach (items((array('orderby' => $types[$type]['orderby']) + $atts)) as $item) {
            echo couponscms_store_item($item);
        }
        echo '</div>';
        echo couponscms_theme_pagination(navigation());
    } else echo '<div class="alert">' . t('theme_no_stores_list',  'Huh :( No stores found here.') . '</div>'; ?>

</div>