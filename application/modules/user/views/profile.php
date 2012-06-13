
<table>
    <tr>
        <td>Имя пользователя:</td>
        <td><?php print $user->username; ?></td>
    </tr>
    <tr>
        <td>Почтовый адрес:</td>
        <td><?php print $user->email; ?></td>
    </tr>
    <tr>
        <td>Роль:</td>
        <td><?php print $user->role; ?></td>
    </tr>
    <tr>
        <td>Статус:</td>
        <td><?php print $user->active ? 'Активен' : 'Забанен'; ?></td>
    </tr>
    <tr>
        <td>Дата регистрации:</td>
        <td><?php print date('d-m-Y H:m', $user->created_date); ?></td>
    </tr>
    <tr>
        <td>Последний визит:</td>
        <td><?php print date('d-m-Y H:i:s', $user->last_login); ?></td>
    </tr>
</table>

<?php print anchor('/user/logout', 'Выйти'); ?>