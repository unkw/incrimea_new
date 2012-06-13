<h3>Меню пользователя</h3>
<div id="user-block" class="block">

<?php if ($this->auth->isLogged()): ?>

<ul>
    <li><?php echo anchor('admin', 'Админ. панель'); ?></li>
    <li><?php echo anchor('user/profile', 'Мой профиль'); ?></li>
    <li><?php echo anchor('user/logout', 'Выйти'); ?></li>
</ul>

<?php else : ?>

<?php echo anchor('user/login', 'Войти'); ?>

<?php endif; ?>

</div>