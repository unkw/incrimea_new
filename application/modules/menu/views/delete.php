<?php if ($menu['id'] == 1): ?>

<div>Админ. меню удалить нельзя :)</div>

<?php else: ?>

<div>Вы действительно хотите удалить меню <i><?php echo $menu['title']; ?></i> ?</div>

<?php print form_open('', array('id' => 'user-delete-form')); ?>
<div class="form-item">
    <?php echo form_hidden('id', $menu['id']); ?>
    <?php echo form_submit('', 'Удалить'); ?>
    <?php echo anchor('admin/menu/list', 'Отмена'); ?>
</div>
<?php print form_close(); ?>

<?php endif; ?>