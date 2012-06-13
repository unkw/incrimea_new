<table id="users-table" class="content-list">

    <thead class="select-all">
    <th><input type="checkbox" title="Выделить всех пользователей" /></th>
    <th>Имя</th>
    <th>Почтовый ящик</th>
    <th>Роль</th>
    <th>Последний вход</th>
    <th>Дата</th>
    <th>Статус</th>
    <th>Действия</th>
    </thead>

    <tbody>
    <?php foreach ($users as $user) : ?>
    <tr>
        <td class="selected"><input type="checkbox" title="Выделить всех пользователей" /></td>
        <td class="username"><?php print $user['username']; ?></td>
        <td class="email"><?php print $user['email']; ?></td>
        <td class="role"><?php print $user['role']; ?></td>
        <td class="last-login"><?php if ($user['last_login']) print date('d.m.Y H:i:s', $user['last_login']); ?></td>
        <td class="created-date"><?php print date('d.m.Y', $user['created_date']); ?></td>
        <td class="status"><?php print $user['active'] ? 'Активен' : 'Забанен'; ?></td>
        <td class="actions">
            <ul>
                <li><?php echo anchor('admin/user/edit/'.$user['id'], ' ', array('class'=>'edit', 'title'=>'Редактировать')) ?></li>
                <li><?php echo anchor('admin/user/delete/'.$user['id'], ' ', array('class'=>'trash', 'title'=>'Удалить')) ?></li>
            </ul>
        </td>
    </tr>
        <?php endforeach; ?>
    </tbody>

    <tbody><tr><td class="pager" colspan="8"><?php print $pager; ?></td></tr></tbody>
</table>