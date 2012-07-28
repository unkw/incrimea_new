<div class="form-item">
    <div><label class="form-label">URL Синоним</label></div>
    <div>
        <?php echo form_checkbox(array(
            'name' => 'path[auto]',
            'id' => 'path-auto',
            'value' => '1',
            'checked' => set_checkbox('path[auto]', 1, isset($auto) ? (bool)$auto : TRUE)
        )); ?>
        <label class="form-desc" for="path-auto">Автоматический синоним</label>
    </div>

    <?php echo form_input(array(
        'name' => 'path[alias]',
        'class' => 'form-text',
        'value' => set_value('path[alias]', isset($alias) ? $alias : '')
    )); ?>

    <?php if (isset($id)) : ?>
        <?php echo form_hidden('alias_id', $id); ?>
    <?php endif; ?>
</div>

