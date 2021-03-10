<?php
$translate = $this->plugin('translate');
$escape = $this->plugin('escapeHtml');
$this->htmlElement('body')->appendAttribute('class', 'item resource show');
$embedMedia = $this->siteSetting('item_media_embed', false);
$itemMedia = $item->media();
?>

<?php echo $this->pageTitle($item->displayTitle(), 2); ?>
<h3><?php echo $translate('Item'); ?></h3>
<?php $this->trigger('view.show.before'); ?>
<?php if ($embedMedia && $itemMedia): ?>
    <div class="media-embeds">
    <?php foreach ($itemMedia as $media):
        echo $media->render();
    endforeach;
    ?>
    </div>
<?php endif; ?>
<?php echo $item->displayValues(); ?>
<section class="metadata">
<div class="property">
    <?php $itemSets = $item->itemSets(); ?>
    <?php if (count($itemSets) > 0): ?>
    <h4><?php echo $translate('Item sets'); ?></h4>
    <?php foreach ($itemSets as $itemSet): ?>
    <div class="value"><a href="<?php echo $escape($itemSet->url()); ?>"><?php echo $itemSet->displayTitle(); ?></a></div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
</section>
<?php if (($this->siteSetting('show_attached_pages', true)) && ($sitePages = $item->sitePages($site->id()))): ?>
<div class="property">
    <h4><?php echo $translate('Site pages'); ?></h4>
    <div class="values">
        <?php foreach ($sitePages as $sitePage): ?>
        <div class="value"><?php echo $sitePage->link($sitePage->title()); ?></div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
<?php if (!$embedMedia && $itemMedia): ?>
<div class="media-list">
    <?php foreach ($itemMedia as $media): ?>
        <?php echo $media->linkPretty(); ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php
$page = $this->params()->fromQuery('page', 1);
$property = $this->params()->fromQuery('property');
$subjectValues = $item->displaySubjectValues($page, 25, $property);
?>
<?php if ($subjectValues): ?>
<div id="item-linked">
    <h3><?php echo $translate('Linked resources'); ?></h3>
    <?php echo $subjectValues; ?>
</div>
<?php endif; ?>

<?php $this->trigger('view.show.after'); ?>