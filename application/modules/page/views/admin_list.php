<table id="pages-table" class="content-list">

    <thead class="select-all">
    <th><input type="checkbox" title="Выделить всё" /></th>
    <th>Заголовок</th>
    <th>Дата</th>
    <th>Статус</th>
    <th>Просмотры</th>
    <th>Действия</th>
    </thead>

    <tbody>
    <?php foreach ($pages as $p) : ?>
    <tr>
        <td class="selected"><input type="checkbox" /></td>
        <td class="title"><?php echo anchor($p['alias'], $p['title']); ?></td>
        <td class="created-date"><?php print date('d.m.Y', $p['created_date']); ?></td>
        <td class="status">
            <?php if ($p['status']): ?>
            <a href="#" class="on" title="Опубликовано"></a>
            <?php else: ?>
            <a href="#" class="off" title="Не опубликовано"></a>
            <?php endif; ?>
        </td>
        <td class="views">-</td>
        <td class="actions">
            <ul>
                <li><?php echo anchor('admin/page/edit/'.$p['id'], ' ', array('class'=>'edit', 'title'=>'Редактировать')) ?></li>
                <li><?php echo anchor('admin/page/delete/'.$p['id'], ' ', array('class'=>'trash', 'title'=>'Удалить')) ?></li>
            </ul>
        </td>
    </tr>
        <?php endforeach; ?>
    </tbody>

    <tbody><tr><td class="pager" colspan="6"><?php print $pager; ?></td></tr></tbody>
</table>



