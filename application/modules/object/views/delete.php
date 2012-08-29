<div>Вы действительно хотите удалить статью  <b><i><?php echo $article['title']; ?></i></b> ?</div>

<?php print form_open('', array('id' => 'user-delete-form')); ?>

<input type="hidden" value="<?php echo $article['id']; ?>" name="id" />

<input type="submit" value="Удалить">
<a href="<?php echo base_url() . 'admin/article/list'; ?>">Отмена</a>

<?php print form_close(); ?>

