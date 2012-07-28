<div class="b-tabs-list">
<?php foreach ($tabs as $tab) : ?>
    <div class="b-tabs-item"><a href="<?php echo base_url().$tab['href']; ?>"><?php echo $tab['title']; ?></a></div>
<?php endforeach; ?>
</div>