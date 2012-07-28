<div class="form-item">
    <div><label class="form-label">Метатеги</label></div>

    <div><label class="form-desc">Заголовок</label></div>
    <?php echo form_input(array(
        'name' => 'meta[title]',
        'class'=> 'form-text',
        'value'=> set_value('meta[title]'),
    ));?>

    <div><label class="form-desc">Ключевые слова</label></div>
    <?php echo form_input(array(
        'name' => 'meta[keywords]',
        'class'=> 'form-text',
        'value'=> set_value('meta[keywords]'),
    ));?>

    <div><label class="form-desc">Описание</label></div>
    <?php echo form_textarea(array(
        'name' => 'meta[description]',
        'class'=> 'form-textarea',
        'rows' => '3',
        'value'=> set_value('meta[description]'),
    ));?>
</div>