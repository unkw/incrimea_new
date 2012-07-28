<div>Вы действительно хотите удалить страницу  <b><i><?php echo $page['title']; ?></i></b> ?</div>

<?php print form_open('', array('id' => 'user-delete-form')); ?>

<input type="hidden" value="<?php echo $page['id']; ?>" name="id" />

<input type="submit" value="Удалить">
<a href="<?php echo base_url() . 'admin/page/list'; ?>">Отмена</a>

<?php print form_close(); ?>

