<?php if ($user['id'] == 1): ?>

<div>Главного администратора удалить нельзя :)</div>

<?php else: ?>

<div>Вы действительно хотите удалить пользователя <i><?php echo $user['username']; ?></i> ?</div>

<?php print form_open('', array('id' => 'user-delete-form')); ?>

<input type="hidden" value="<?php echo $user['id']; ?>" name="id" />

<input type="submit" value="Удалить">
<a href="<?php echo base_url() . 'admin/user/list'; ?>">Отмена</a>

<?php print form_close(); ?>

<?php endif; ?>