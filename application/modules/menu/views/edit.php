<?php echo form_open('', array('id' => 'menu-edit-form')); ?>

<div class="form-item">
    <div><?php echo form_label('Название:', 'menu[title]', array('class'=>'form-label')); ?><span class="red"> *</span></div>
    <?php echo form_error('menu[title]'); ?>
    <?php echo form_input(array(
        'id' =>   'menu-title',
        'name' => 'menu[title]',
        'class' => 'form-text',
        'value' => set_value('menu[title]', $menu['title'])
    )); ?>
</div>

<div class="form-item">
    <div><?php echo form_label('Машинное имя:', 'menu[name]', array('class'=>'form-label')); ?><span class="red"> *</span></div>
    <?php echo form_error('menu[name]'); ?>
    <?php echo form_input(array(
        'id' =>   'menu-name',
        'name' => 'menu[name]',
        'class' => 'form-text',
        'value' => set_value('menu[name]', $menu['name'])
    )); ?>
</div>

<div class="form-item">
    <div><?php echo form_label('Описание:', 'menu[desc]', array('class'=>'form-label')); ?></div>
    <?php echo form_textarea(array(
        'id' =>   'menu-desc',
        'name' => 'menu[desc]',
        'class' => 'form-textarea',
        'rows' => '3',
        'value' => set_value('menu[desc]', $menu['desc'])
    )); ?>
</div>

<?php if ($menu['id']): ?>
    <?php echo form_hidden('id', $menu['id']); ?>
    <?php echo form_submit('', 'Сохранить'); ?>
    <?php echo anchor('admin/menu/list', 'Отмена'); ?>
<?php else : ?>

<div class="form-item">
    <?php echo form_submit('', 'Создать'); ?>
</div>
    
<?php endif; ?>

<?php echo form_close(); ?>