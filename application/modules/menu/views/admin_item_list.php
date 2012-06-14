<!--<table id="menu-items-table" class="content-list">-->
<!---->
<!--    <thead class="select-all">-->
<!--    <th><input type="checkbox" title="Выделить все" /></th>-->
<!--    <th>Пункт меню</th>-->
<!--    <th>Действия</th>-->
<!--    </thead>-->
<!---->
<!--    <tbody>-->
<!--    --><?php //foreach ($items as $item) : ?>
<!--        <tr class="menu-item">-->
<!--            <td class="selected"><input type="checkbox" title="Выделить все" /></td>-->
<!--            <td class="title">-->
<!--                <a class="drag-handler-wrap"><div class="drag-handler"></div></a>-->
<!--                --><?php //echo anchor($item['href'], $item['name']); ?>
<!--            </td>-->
<!--            <td class="actions">-->
<!--                <ul>-->
<!--                    <li>--><?php //echo anchor('admin/menu/item/edit/'.$item['id'], ' ', array('class'=>'edit', 'title'=>'Редактировать')) ?><!--</li>-->
<!--                    <li>--><?php //echo anchor('admin/menu/item/delete/'.$item['id'], ' ', array('class'=>'trash', 'title'=>'Удалить')) ?><!--</li>-->
<!--                </ul>-->
<!--            </td>-->
<!--        </tr>-->
<!--    --><?php //endforeach; ?>
<!--    </tbody>-->
<!---->
<!--</table>-->

<?php

    echo tree_edit_menu($items, array('id'=>'tree-sortable'));

?>

<?php echo anchor('admin/menu/'.$menu_name.'/items/add', 'Добавить пункт'); ?>

<script type="text/javascript">

    $(function(){

        $('#tree-sortable').treeSortable({

        });
    });

</script>