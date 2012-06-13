<table id="menu-table" class="content-list">

<thead class="select-all">
    <th><input type="checkbox" title="Выделить все меню" /></th>
    <th>Название</th>
    <th>Действия</th>
</thead>

<tbody>
    <?php foreach ($menu as $m) : ?>
    <tr>
        <td class="selected"><input type="checkbox" title="Выделить все меню" /></td>
        <td class=""><?php echo anchor('admin/menu/'.$m['name'].'/items', $m['title']); ?></td>
        <td class="actions">
            <ul>
                <li><?php echo anchor('admin/menu/edit/'.$m['id'], ' ', array('class'=>'edit', 'title'=>'Редактировать')) ?></li>
                <li><?php echo anchor('admin/menu/delete/'.$m['id'], ' ', array('class'=>'trash', 'title'=>'Удалить')) ?></li>
            </ul>
        </td>
    </tr>
        <?php endforeach; ?>
</tbody>

<tbody><tr><td class="pager" colspan="5"><?php print $pager; ?></td></tr></tbody>
</table>