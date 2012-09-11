
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
            <input type="text" name="object[title]" class="form-text" value="<?php echo set_value('page[title]') ?>"/>
        </div>

        <!-- Информация для администрации сайта -->
        <div class="form-item">
            <div><label class="form-label">Информация для администрации сайта</label></div>
            <textarea name="object[admin_info]" class="form-textarea"><?php echo set_value('admin_info'); ?></textarea>
        </div>

        <!-- Курорт -->
        <div class="form-item">
            <div><label class="form-label">Курорт</label></div>
            <?php 
                echo Modules::run('resorts/dropdown', array(
                    'name' => 'object[resort_id]',
                    'class' => 'form-select',
                    'value' => set_value('object[resort_id]', '')
                )); 
            ?>
        </div>

        <!-- Метатеги -->
        <?php echo Modules::run('metatags/create_form'); ?>

        <!-- Краткая информация (для превью) -->
        <div class="form-item">
            <div><label class="form-label">Краткая информация (для превью)</label></div>
            <textarea name="object[short_info]" class="form-textarea"><?php echo set_value('short_info'); ?></textarea>
        </div>

        <div class="form-row">
            <!-- Тип объекта -->
            <div class="form-item">
                <div><label class="form-label">Тип объекта</label></div>
                <?php echo form_dropdown('object[type_id]', $obj['types'], set_value('object[type_id]'), ' class="form-select"'); ?>
            </div>
            <!-- Цены -->
            <div class="form-item short">
                <div><label class="form-label">Цены от (грн)</label></div>
                <input type="text" name="object[price]" class="form-text" value="<?php echo set_value('object[price]') ?>"/>
            </div>
        </div>

        <!-- Питание -->
        <div class="form-item">
            <div><label class="form-label">Питание</label></div>
            <input type="text" name="object[food]" class="form-text" value="<?php echo set_value('object[food]') ?>"/>
        </div>

        <!-- Пляж -->
        <div class="form-item view_row">
            <div class="form-label">Пляж</div>
            <div class="form-item-tr">
                <div class="form-item-td">
                    <div class="form-desc">Тип</div>
                    <?php echo form_dropdown('object[beach_id]', $obj['beach']['type'], set_value('object[beach_id]'), ' class="form-select"'); ?>
                </div>
                <div class="form-item-td">
                    <div class="form-desc">Расстояние</div>
                    <?php echo form_dropdown('object[beach_distance_id]', $obj['beach']['distance'], set_value('object[beach_distance_id]'), ' class="form-select"'); ?>
                </div>
            </div>
        </div>

        <div class="form-item clear">
            <div><label class="form-label">Настройки публикации</label></div>
            <label>
                <input type="checkbox" name="object[status]" value="1" <?php echo set_checkbox('object[status]', 1, TRUE); ?> />
                Опубликовано
            </label>
            <label>
                <?php
                $options = array();
                for ($i = 0; $i < 11; $i++) {
                    $options[$i] = $i;
                }
                ?>
                <?php echo form_dropdown('object[priority]', $options, set_value('object[priority]'), ' class="form-select"'); ?>
                Приоритет
            </label>
        </div>

        <!-- Синонимы -->
        <?php echo $this->path_lib->create_form(); ?>

        <input type="submit" value="Создать" />
        <?php echo anchor('admin/object/list', 'Отмена'); ?>

    </td>

    <td class="right-col">

        <!-- Галерея -->
        <div class="form-item">
            <div><label class="form-label">Галерея</label></div>
            <div class="b-upload">
                <input type="file" class="js-file-upload" data-module="object" />
                <input type="button" class="js-upload-btn" value="Загрузить" />
                <div class="b-upload-list"></div>
                <?php if (set_value('object[img]')) : ?>
                    <?php foreach ($_POST['object']['img'] as $img): ?>
                    <input type="hidden" class="js-tmp-src" value="<?php echo $img; ?>" />
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="clear"></div>
            </div>
        </div>

        <!-- Чекбоксы -->
        <div class="form-row">

            <!-- В номере -->
            <div class="form-item">
                <div class="form-label"><label class="label">В номере</label></div>
                <ul class="form-cbx-list">
                <?php $checked_arr = isset($_POST['object']['in_room']) ? $_POST['object']['in_room'] : array(); ?>
                <?php foreach ($obj['in_room'] as $prop) : ?>
                    <li class="form-cbx-item">
                        <label>
                            <?php echo form_checkbox('object[in_room][]', $prop['url_name'], in_array($prop['url_name'], $checked_arr)) ?>
                            <?php echo $prop['name']; ?>
                        <label>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>

            <!-- Инфраструктура -->
            <div class="form-item">
                <div class="form-label"><label class="label">Инфраструктура</label></div>
                <ul class="form-cbx-list">
                    <?php $checked_arr = isset($_POST['object']['infr']) ? $_POST['object']['infr'] : array(); ?>
                    <?php foreach ($obj['infr'] as $prop) : ?>
                    <li class="form-cbx-item">
                        <label>
                            <?php echo form_checkbox('object[infr][]', $prop['url_name'], in_array($prop['url_name'], $checked_arr)) ?>
                            <?php echo $prop['name']; ?>
                            <label>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Развлечения -->
            <div class="form-item">
                <div class="form-label"><label class="label">Развлечения</label></div>
                <ul class="form-cbx-list">
                    <?php $checked_arr = isset($_POST['object']['entment']) ? $_POST['object']['entment'] : array(); ?>
                    <?php foreach ($obj['entment'] as $prop) : ?>
                    <li class="form-cbx-item">
                        <label>
                            <?php echo form_checkbox('object[entment][]', $prop['url_name'], in_array($prop['url_name'], $checked_arr)) ?>
                            <?php echo $prop['name']; ?>
                            <label>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="form-item">
                <!-- Сервис -->
                <div class="form-label"><label class="label">Сервис</label></div>
                <ul class="form-cbx-list">
                    <?php $checked_arr = isset($_POST['object']['service']) ? $_POST['object']['service'] : array(); ?>
                    <?php foreach ($obj['service'] as $prop) : ?>
                    <li class="form-cbx-item">
                        <label>
                            <?php echo form_checkbox('object[service][]', $prop['url_name'], in_array($prop['url_name'], $checked_arr)) ?>
                            <?php echo $prop['name']; ?>
                            <label>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Для детей -->
                <div class="form-label"><label class="label">Для детей</label></div>
                <ul class="form-cbx-list">
                    <?php $checked_arr = isset($_POST['object']['for_child']) ? $_POST['object']['for_child'] : array(); ?>
                    <?php foreach ($obj['for_child'] as $prop) : ?>
                    <li class="form-cbx-item">
                        <label>
                            <?php echo form_checkbox('object[for_child][]', $prop['url_name'], in_array($prop['url_name'], $checked_arr)) ?>
                            <?php echo $prop['name']; ?>
                            <label>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>

        <!-- Основное описание -->
        <div class="form-item clear">
            <div><label class="form-label">Основное описание</label></div>
            <?php $this->ckeditor->editor('object[body]', html_entity_decode(set_value('object[body]'))); ?>
        </div>

    </td>

</tr></tbody></table>

<?php echo form_close(); ?>