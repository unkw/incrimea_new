
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
            <input type="text" name="article[title]" class="form-text" value="<?php echo set_value('article[title]', $article['title']) ?>"/>
        </div>

        <!-- Курорт -->
        <div class="form-item">
            <div><label class="form-label">Курорт</label></div>
            <?php
            echo Modules::run('resorts/dropdown', array(
                'name' => 'article[resort_id]',
                'value' => set_value('article[resort_id]', $article['resort_id'])
            ));
            ?>
        </div>

        <!-- Титульное изображение -->
        <div class="form-item">
            <div><label class="form-label">Титульное изображение</label></div>
            <div class="b-upload">
                <input type="file" class="js-file-upload" data-module="article" data-limit=1 />
                <input type="button" class="js-upload-btn" value="Загрузить" />
                <div class="b-upload-list"></div>
                <?php if (set_value('article[img]', $article['img'])) : ?>
                <input type="hidden" class="js-tmp-src" value="<?php echo set_value('article[img]', $article['img']); ?>" />
                <?php endif; ?>
                <div class="clear"></div>
            </div>
        </div>
        
        <!-- Метатеги -->
        <?php echo Modules::run('metatags/edit_form', $article['meta_id']); ?>

        <div class="form-item">
            <div><label class="form-label">Настройки публикации</label></div>
            <label>
                <input type="checkbox" name="article[status]" value="1" <?php echo set_checkbox('article[status]', 1, (bool)$article['status']); ?> />
                Опубликовано
            </label>
            <label>
                <input type="checkbox" name="article[sticky]" value="1" <?php echo set_checkbox('article[sticky]', 1, (bool)$article['sticky']); ?> />
                Закреплять вверху списка
            </label>
        </div>

        <!-- Синонимы -->
        <?php echo $this->path_lib->edit_form($article['alias_id']); ?>

        <input type="submit" value="Сохранить" />
        <?php echo anchor('admin/page/list', 'Отмена'); ?>

    </td>

    <td class="right-col">

        <div class="form-item">
            <div><label class="form-label">Текст страницы</label></div>
            <?php $this->ckeditor->editor('article[body]', html_entity_decode(set_value('article[body]', $article['body']))); ?>
        </div>

    </td>

</tr></tbody></table>

<?php echo form_close(); ?>