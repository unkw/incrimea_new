/**
 * Author: Kemal
 * Date: 29.07.12
 * Time: 21:57
 */
App.ns('modules');

App.modules.admin = (function(self) {

    "use strict";
    
    function init() {
        
        $('.js-file-upload').each(function() {
            new uploaderInstance($(this));  
        });
    }

    /**
     * Instance of the class image uploader
     * @param el {jQuery object}
     */
    function uploaderInstance(el) {
        
        var self = this;
        
        this.el = el;
        this.wrap = this.el.parent().find('.b-upload-list').sortable({
            items: '.b-upload-item'
        });
        this.uploadBtn = this.el.parent().find('.js-upload-btn')
            .click(function() {self.el.Uploader('startUpload');});
        
        this.module = this.el.data('module');
        this.multiple = this.el.prop('multiple');
        this.limit = this.el.data('limit') || 25;
    
        this.uploader = this.el.Uploader({
            url: '/admin/' + this.module + '/upload',
            fieldName: 'images',
            multiple: this.multiple,
            limit: this.limit,
            onSelect: function(file) {self.onSelect(file);},
            onLimitExceeded: function() {self.onLimitExceeded();},
            onAllComplete: function() {self.onAllComplete();}
        });
        
        // init loaded images
        this.el.parent().find('.js-tmp-src').each(function() {
            self.addItem($(this).val());
        });
        
    }

    uploaderInstance.prototype = {
        /**
         * @param file {object}
         */
        onSelect: function(file) {
            var self = this, item;

            if (this.limit <= this.wrap.find('.b-upload-item').length) {
                return;
            }

            if (file.size > 2000000) {
                trace('Файл ' + file.name + ': превышен размер файла(не более 2MB)');
                return;
            }

            if (file.name.match(/[А-Яа-я]+/)) {
                trace('Файл ' + file.name + ': русские символы в названии файла недопустимы');
                return;
            }

            var uploadId = this.el.Uploader('addItem', {
                file: file,
                onStart: function() {
                    item.find('.b-upload-ajax').removeClass('state_disable');
                },
                onComplete: function(data) {
                    item.find('.b-upload-ajax').addClass('state_disable');
                    item.find('img').removeClass('state_ready');
                    var attrName = self.module + '[img]' + (self.limit > 1 ? '[]' : ''); 
                    item.find('.js-src').attr('name', attrName).val(data);
                }
            });

            var reader = new FileReader();
            reader.onload = (function() {
                return function(e) {
                    self.addItem(e.target.result, uploadId, function(elm) {
                        item = elm;
                    });
                };
            })();
            reader.readAsDataURL(file);            
        },
        onLimitExceeded: function() {
            
        },
        onAllComplete: function() {
                
        },
        /**
         * Adding image item to DOM
         * @param src {string}
         * @param uploadId {string}
         * @param clb {function}
         */
        addItem: function(src, uploadId, clb) {
        
            var self = this;
            
            App.post('loader.tpl', 'mdl-upload-item', function(tpl) {
                
                var item = $(tpl),
                    path = uploadId ? src : '/asset/img/' + this.module + '/120x90/' + src;
                
                item.find('img').attr('src', path);
                item.find('.b-upload-remove a').click(function() {
                    $(this).closest('.b-upload-item').remove();
                    if (uploadId) {
                        self.el.Uploader('cancel', uploadId);
                    }
                    return false;
                });
                
                if (uploadId) {
                    item.find('img').addClass('state_ready');
                } else {
                    var attrName = this.module + '[img]' + (this.limit > 1 ? '[]' : '');
                    item.find('.js-src').val(src).attr('name', attrName);                    
                }
                
                this.wrap.append(item);
                
                if ($.isFunction(clb)) {
                    clb.call(self, item);
                }
            }, this);
            
        }
    };

    App.on('App.ready', init);

    return self;

})(App.modules.admin || {});
