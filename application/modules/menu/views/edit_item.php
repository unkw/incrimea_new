<?php echo form_open('', array('id' => 'menu-item-form')); ?>

<div class="form-item">
    <div><?php echo form_label('Название ссылки в меню:', 'item[name]', array('class'=>'form-label')); ?><span class="red"> *</span></div>
    <?php echo form_error('item[name]'); ?>
    <?php echo form_input(array(
        'id' =>   'item-name',
        'name' => 'item[name]',
        'class' => 'form-text',
        'value' => set_value('item[name]', $item['name'])
    )); ?>
</div>

<div class="form-item">
    <div><?php echo form_label('Адрес:', 'item[name]', array('class'=>'form-label')); ?><span class="red"> *</span></div>
    <div class="form-desc">Адрес нужно ввести без "/" в начале (user/login)</div>
    <?php echo form_error('item[href]'); ?>
    <?php echo form_input(array(
        'id' =>   'item-href',
        'name' => 'item[href]',
        'class' => 'form-text',
        'value' => set_value('item[href]', $item['href'])
    )); ?>
</div>

<div class="form-item">
    <div><?php echo form_label('Атрибут title:', 'item[title]', array('class'=>'form-label')); ?></div>
    <?php echo form_error('item[title]'); ?>
    <?php echo form_input(array(
        'id' =>   'item-title',
        'name' => 'item[title]',
        'class' => 'form-text',
        'value' => set_value('item[title]', $item['title'])
    )); ?>
</div>

<div class="form-item">
    <?php echo form_checkbox(array(
        'id' =>   'item-active',
        'name' => 'item[active]',
        'class' => 'form-checkbox',
        'value' => 1,
        'checked' => (bool)set_value('item[active]', $item['active'])
    )); ?>
    <?php echo form_label('Включено', 'item-active'); ?>
</div>

<!-- РОДИТЕЛЬСКИЙ ПУНКТ -->
<div class="form-item">
    <?php $options = tree_dropdown_options($items, $item['id']); ?>
    <div><?php echo form_label('Родительский пункт:', 'item-parent-id', array('class'=>'form-label')); ?></div>
    <?php echo form_error('item[parent_id]'); ?>
    <?php echo form_dropdown(
        'item[parent_id]', $options, set_value('item[parent_id]', $item['parent_id']),
        'class="form-select" id="item-parent-id"');
    ?>
</div>

<?php if ($item['id']) : ?>
    <?php echo form_submit('', 'Сохранить'); ?>
    <?php echo anchor('admin/menu/item/delete/'.$item['id'], 'Удалить'); ?>
<?php else : ?>
    <?php echo form_submit('', 'Добавить'); ?>
<?php endif; ?>

<?php echo form_close(); ?>