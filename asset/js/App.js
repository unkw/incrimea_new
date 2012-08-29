
var App = (function(self, window, document, $) {
    
    "use strict";
    
    var listeners = {};
    
    self.ns = function(nsString) {
        
        var p = nsString.split('.'), i, len, c;
        
        c = this;
        for (i = 0, len = p.length; i < len; i++) {
            c[p[i]] = c[p[i]] || {};
            c = c[p[i]];
        }
    };
    
    self.on = function(event, clb, scope) {
        
        event = event.split('.');
        var module = event[0], action = event[1], o;
        
        o = listeners[module] || {};
        
        if (o[action] === undefined) {
            o[action] = [];
        }
        
        o[action].push({
            clb: clb,
            scope: scope
        });
        
        listeners[module] = o;
    };
    
    self.trigger = function(event) {
        
        event = event.split('.');
        var module = event[0], action = event[1];
        
        if (listeners[module] && listeners[module][action]) {
            var args = [].slice.call(arguments, 1),
                tmp_listeners = listeners[module][action].slice();
            
            for (var i = 0, len = tmp_listeners.length; i < len; i++) {
                tmp_listeners[i].clb.apply(tmp_listeners[i].scope || this, args);
            }
        }
    };
    
    self.extend = function(parent, child) {
        
    };
    
    self.post = function(data) {
        
        data = data.split('.');
        var p = {
            module: data[0],
            action: data[1],
            msg: []
        };
            
        for (var i = 1, len = arguments.length; i < len; i++) {
            p.msg.push(arguments[i]);
        }
    
        return postMessage(p);
    };
    
    function postMessage(p) {
        
        if (!self.modules[p.module] || typeof self.modules[p.module][p.action] !== 'function') {
            // Add to queue
        } else {
            return self.modules[p.module][p.action].apply(self.modules[p.module], p.msg) || true;
        }

        return false;        
    }
    
    $(function() {
        self.trigger('App.ready');
    });
    
    return self;
    
})(App || {}, window, document, $);