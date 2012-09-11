/**
 * User: admin
 * Date: 02.09.12
 * Time: 15:28
 */
App.ns('modules');

App.modules.admin = (function(self) {

    function init() {

        // Синхронизация "в номере" с комнатами
        syncInRoom();

    }

    function syncInRoom() {
    }

    App.on('App.ready', init);

    return self;

})(App.modules.admin || {});
