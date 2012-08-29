/**
 * jQuery-плагин, облегчающий загрузку файлов на сервер.
 *
 */

(function($) {

    // defining compatibility of upload control object
    var xhrUploadFlag = false;
    if(window.XMLHttpRequest) {
        var testXHR = new XMLHttpRequest();
        xhrUploadFlag = (testXHR.upload != null);
    }

    // utility object for checking browser compatibility
    $.extend($.support, {
        fileSelecting: (window.File != null) && (window.FileList != null),
        fileReading: (window.FileReader != null),
        fileSending: (window.FormData != null),
        uploadControl: xhrUploadFlag
    });

    // generating uniq id
    function uniq(length, prefix) {
        length = parseInt(length);
        prefix = prefix || '';
        if((length == 0) || isNaN(length)) {
            return prefix;
        }
        var ch = String.fromCharCode(Math.floor(Math.random() * 26) + 97);
        return prefix+ch+uniq(--length);
    }

    ////////////////////////////////////////////////////////////////////////////
    // plugin code
    $.fn.Uploader = function(params, data) {

        if(this.length == 0) {
            return this;
        }

        // context
        var self = this;

        // locals
        var queue = self._UploaderQueue;
        var set = self._UploaderSettings || {};

        ////////////////////////////////////////////////////////////////////////
        // initialization (on first call)
        if(!params || $.isPlainObject(params)) {

            /* default settings */
            self._UploaderSettings = $.extend({
                url: '/upload.php',
                multiple: true,
                fieldName: 'file',
                dropping: true,
                dropBox: false,
                limit: false,
                onSelect: false,
                onLimitExceeded: false,
                onAllComplete: false
            }, params || {});

            /* private properties */
            self._UploaderQueue = {};
            self._UploaderItemsCount = 0;
            queue = self._UploaderQueue;
            set = self._UploaderSettings;

            /* private items-adding method */
            self._UploaderFilesAddMap = function(files, callback) {

                var callbackDefined = $.isFunction(callback);
                if(!$.support.fileSelecting) {
                    if(self._UploaderItemsCount === set.limit) {
                        return $.isFunction(set.onLimitExceeded) ? set.onLimitExceeded.call(self) : false;
                    }
                    var file = {
                        fake: true,
                        name: files.value,
                        inputElement: files
                    };
                    if(callbackDefined) {
                        if(!callback.call(self, file)) {
                            return true;
                        }
                    }
                    self.Uploader('addItem', file);
                    return true;
                }
                if(files instanceof FileList) {
                    $.each(files, function(i, file) {
                        if(self._UploaderItemsCount === set.limit) {
                            if(self._UploaderItemsCount === set.limit) {
                                return $.isFunction(set.onLimitExceeded) ? set.onLimitExceeded.call(self) : false;
                            }
                        }
                        if(callbackDefined) {
                            if(!callback.call(self, file)) {
                                return true;
                            }
                        }
                        self.Uploader('addItem', {
                            file: file
                        });
                    });
                }
                return true;
            };


            /* private file-uploading method */
            self._UploaderUploadItem = function(url, item, queueId) {
                if(!(item.file instanceof File)) {
                    return false;
                }
             
                if($.support.fileSending) {
                    var formData = new FormData();
                    formData.append((item.fieldName || 'file'), item.file);
                    if ($.isFunction(item.onStart)) {
                        item.onStart.call(this);
                    }
                    $.ajax({
                        url: url,
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function(response) {
                            if (!item.cancelled) {
                                delete queue[queueId];
                                self._UploaderItemsCount--;
                            }
                            if ($.isFunction(item.onComplete)) {
                                item.onComplete.call(this, response);
                            }

                            if((self._UploaderItemsCount == 0) && ($.isFunction(set.onAllComplete))) {
                                set.onAllComplete.call(self);
                            }                            
                        }
                    });
                }
            }

            /* binding callbacks */
            var isFileField = ((self.get(0).tagName == 'INPUT') && (this.attr('type') == 'file'));

            if(isFileField) {
                var myName = self.eq(0).attr('name');
                if(!$.support.fileSelecting) {
                    if(myName.charAt(myName.length-1) != ']') {
                        myName += '[]';
                    }
                    self.attr('name', myName);
                    self.attr('multiple', false);
                    var action = self.parents('form').attr('action');
                    self._UploaderFakeForm = $('<form/>').attr({
                        method: 'post',
                        enctype: 'multipart/form-data',
                        action: action
                    }).hide().appendTo('body');
                } else {
                    self.attr('multiple', true);
                }

                self._UploaderChangeCallback = function() {
                    self._UploaderFilesAddMap($.support.fileSelecting ? this.files : this, set.onSelect);
                };

                self.bind({
                    change: self._UploaderChangeCallback
                });
            }

            if(set.dropping) {
                self.bind({
                    drop: function(e) {
                        self._UploaderFilesAddMap(e.originalEvent.dataTransfer.files, set.onSelect);
                        return false;
                    }
                });
                if(set.dropBox) {
                    $(set.dropBox).bind({
                        drop: function(e) {
                            self._UploaderFilesAddMap(e.originalEvent.dataTransfer.files, set.onSelect);
                            return false;
                        }
                    });
                }
            }
            return self;
        }


        ////////////////////////////////////////////////////////////////////
        // controls
        switch(params) {

            case 'addItem':

                if(!data) {
                    return false;
                }
                var queueId = uniq(5);

                if(data.file.fake) {
                    var input = $(data.file.inputElement);
                    var cloned = $(input).clone();
                    $(input).before(cloned);
                    $(input).attr('id', queueId);
                    $(input).appendTo(self._UploaderFakeForm);
                    cloned.bind({
                        change: self._UploaderChangeCallback
                    });
                    self._UploaderItemsCount++;
                    return queueId;
                }

                if(!(data.file instanceof File)) {
                    return false;
                }
                queue[queueId] = data;
                self._UploaderItemsCount++;
                return queueId;
                break;

            case 'startUpload':
                if(!set.url) {
                    return self;
                }
                if(!$.support.fileSelecting) {
                    self._UploaderFakeForm.submit();
                    return self;
                }
                $.each(queue, function(queueId, item) {
                    item.fieldName = item.fieldName || set.fieldName;
                    self._UploaderUploadItem(set.url, item, queueId);
                });
                break;

            case 'itemsCount':
                return self._UploaderItemsCount;
                break;

            case 'cancelAll':
                if(!$.support.fileSelecting) {
                    self._UploaderItemsCount = 0;
                    self._UploaderFakeForm.empty();
                    return self;
                }
                $.each(queue, function(key, item) {
                    self.Uploader('cancel', key);
                });
                break;

            case 'cancel':
                var queueId = data.toString();
                if(self._UploaderItemsCount > 0) {

                    if(!$.support.fileSelecting) {
                        var removingItem = $('#'+queueId);
                        if(removingItem.length > 0) {
                            removingItem.remove();
                            self._UploaderItemsCount--;
                        }
                        return self;
                    }

                    if(queue[queueId] !== undefined) {
                        if(queue[queueId].xhr) {
                            queue[queueId].cancelled = true;
                            queue[queueId].xhr.abort();
                        }
                        delete queue[queueId];
                        self._UploaderItemsCount--;
                    }
                    if (!self._UploaderSettings.multiple) {
                        self.val('');    
                    }
                }
                break;

            case 'setParam':
                var acceptParams = ['url', 'multiple', 'fieldName', 'limit'];
                $.each(data, function(key, val) {
                    if($.inArray(key, acceptParams)) {
                        self._UploaderSettings[key] = val;
                    }
                });
                break;
        }

        return self;
    };

})(jQuery);