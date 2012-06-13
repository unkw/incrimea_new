<div>Вы действительно хотите удалить пункт меню <i><?php echo $item['name']; ?></i> ?</div>

<?php print form_open('', array('id' => 'menu-item-delete-form')); ?>
<div class="form-item">
    <?php echo form_hidden('id', $item['id']); ?>
    <?php echo form_submit('', 'Удалить'); ?>
    <?php echo anchor('admin/menu/list', 'Отмена'); ?>
</div>
<?php print form_close(); ?>