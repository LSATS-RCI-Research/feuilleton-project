<?php
$translate = $this->plugin('translate');
$escape = $this->plugin('escapeHtml');
$this->htmlElement('body')->appendAttribute('class', 'item resource browse');

$query = $this->params()->fromQuery();
$itemSetShow = isset($itemSet);
if ($itemSetShow):
    $this->htmlElement('body')->appendAttribute('class', 'item-set');
    $query['item_set_id'] = $itemSet->id();
endif;
$sortHeadings = [
    [
        'label' => $translate('Title'),
        'value' => 'dcterms:title'
    ],
    [
        'label' => $translate('Identifier'),
        'value' => 'dcterms:identifier'
    ],
    [
        'label' => $translate('Class'),
        'value' => 'resource_class_label'
    ],
    [
        'label' => $translate('Created'),
        'value' => 'created'
    ],
];
?>

<?php if ($itemSetShow): ?>
    <?php echo $this->pageTitle($itemSet->displayTitle(), 2); ?>
    <h3><?php echo $translate('Item set'); ?></h3>
    <div class="metadata">
        <?php echo $itemSet->displayValues(); ?>
    </div>
    <div class="item-set-items">
    <?php echo '<h3>' . $escape($translate('Items')) . '</h3>'; ?>
<?php else: ?>
    <?php echo $this->pageTitle($translate('Items'), 2); ?>
<?php endif; ?>

<?php echo $this->searchFilters(); ?>

<div class="browse-controls">
    <?php echo $this->pagination(); ?>
    <?php echo $this->hyperlink($translate('Advanced search'), $this->url('site/resource', ['controller' => 'item', 'action' => 'search'], ['query' => $query], true), ['class' => 'advanced-search']); ?>
    <?php echo $this->sortSelector($sortHeadings); ?>
</div>

<?php $this->trigger('view.browse.before'); ?>
<ul class="resource-list">
<?php
$headingTerm = $this->siteSetting('browse_heading_property_term');
$bodyTerm = $this->siteSetting('browse_body_property_term');
foreach ($items as $item):
    $heading = $headingTerm ? $item->value($headingTerm, ['default' => $translate('[Untitled]')]) : $item->displayTitle();
    $body = $bodyTerm ? $item->value($bodyTerm) : $item->displayDescription();
?>
    <li class="item resource">
        <?php if ($itemThumbnail = $this->thumbnail($item, 'medium')): ?>
        <?php echo $item->linkRaw($itemThumbnail); ?>
        <?php endif; ?>
        <h5><?php echo $item->link($heading); ?></h5>
        <?php if ($body): ?>
        <div class="description"><?php echo $escape($body); ?></div>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>
<?php echo ($itemSetShow) ? '</div>' : ''; ?>
<?php $this->trigger('view.browse.after'); ?>
<?php echo $this->pagination(); ?>