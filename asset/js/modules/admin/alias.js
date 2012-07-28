/**
 * Включение/выключение поля синонима в форме
 * создания/редактирования контента
 *
 * @author: Kemal
 * @date: 11.07.12
 * @time: 23:58
 */
App.ns('modules');

App.modules.admin = (function(self) {

    var autoCheckbox, aliasInput;

    function init() {
        autoCheckbox = $('input[name="path[auto]"]').change(function(){
            aliasInput.prop('disabled', $(this).prop('checked') ? true : false);
        });
        aliasInput = $('input[name="path[alias]"]').prop('disabled', autoCheckbox.prop('checked') ? true : false);
    }

    App.on('App.ready', init);

    return self;

})(App.modules.admin || {});


