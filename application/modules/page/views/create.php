
<?php if (validation_errors()): ?>
<div id="error_msg" class="message-box">
    <?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<?php echo form_open('', array('class' => 'edit-content')); ?>

<table><tbody><tr>

    <td class="left-col">

        <div class="form-item">
            <div><label class="form-label">Заголовок</label></div>
            <input type="text" name="page[title]" class="form-text" value="<?php echo set_value('page[title]') ?>"/>
        </div>

        <!-- Метатеги -->
        <?php echo Modules::run('metatags/create_form'); ?>

        <div class="form-item">
            <div><label class="form-label">Настройки публикации</label></div>
            <label>
                <input type="checkbox" name="page[status]" value="1" <?php echo set_checkbox('page[status]', 1, TRUE); ?> />
                Опубликовано
            </label>
            <label>
                <input type="checkbox" name="page[sticky]" value="1" <?php echo set_checkbox('page[sticky]', 1); ?>/>
                Закреплять вверху списка
            </label>
        </div>

        <!-- Синонимы -->
        <?php echo $this->path_lib->create_form(); ?>

        <input type="submit" value="Создать" />
        <?php echo anchor('admin/page/list', 'Отмена'); ?>

    </td>

    <td class="right-col">

        <div class="form-item">
            <div><label class="form-label">Текст страницы</label></div>
            <?php $this->ckeditor->editor('page[body]', html_entity_decode(set_value('page[body]'))); ?>
        </div>

    </td>

</tr></tbody></table>

<?php echo form_close(); ?>