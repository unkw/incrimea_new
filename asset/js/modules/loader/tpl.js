/**
 * Author: Kemal
 * Date: 30.07.12
 * Time: 10:24
 */
App.ns('modules');

App.modules.loader = (function(self) {

    var tpls = {}, 
        loader = {};
    
    self.tpl = function(name, clb, scope) {
        if (!tpls[name]) {
            if(!loader[name]) {
                loader[name] = $.ajax({
                    url     : '/asset/tpl/' + name + '.tpl',
                    type    : 'get',
                    dataType: 'html'
                })
            }
            loader[name].success(function (response) {
                tpls[name] = response;

                if ($.type(clb) === 'function') {
                    clb.call(scope || self, response);
                }
            });
        }
        else if ($.type(clb) === 'function') {
            clb.call(scope || self, tpls[name]);
        }    
    }
    
    return self;
    
})(App.modules.loader || {});