CKEDITOR.dialog.add('filesDialog', function (editor) {
    return {
        title: 'Вставить ссылку на файл',
        minWidth: 400,
        minHeight: 300,

        contents: [
            {
                id: 'tab-upload',
                label: 'Загрузить файл',
                expand : true,
                elements: [
                    {
                        type: 'iframe',
                        //id: 'iframe',
                        src: '/file-upload-goes-here/',
                        width: '100%',
                        height: '200px',
                        onContentLoad : function(a) {
                            // Iframe is loaded...
                         },
                    }
                ]
            },
            {
                id: 'tab-basic',
                label: 'Выбрать из списка',
                elements: [
                    {
                        type: 'select',
                        id: 'file-browser',
                        label: 'Select a file',
                        items: [],
                        onLoad: function (api) {
                            var s = this;
                            jQuery.ajax({
                                url: '/ltst-files/',
                                dataType: 'json',
                                success: function (data) {
                                    $(s.getInputElement().$).html('<option value="">--- Выберите файл ---</option>');
                                    for (var i in data) {
                                        $(s.getInputElement().$).append('<option value="' + data[i].url + '">' + data[i].name + '</option>');
                                    }

                                }
                            });

                        },
                        onChange: function (api) {
                            this.getDialog().getContentElement('tab-basic', 'title').setValue($('option:selected', this.getInputElement().$).text());
                            this.getDialog().getContentElement('tab-basic', 'href').setValue(this.getValue());
                        }
                    },
                    {
                        type: 'text',
                        id: 'href',
                        label: 'Ссылка',
                        validate: CKEDITOR.dialog.validate.notEmpty("Ссылка не может быть пустой")
                    },
                    {
                        type: 'text',
                        id: 'title',
                        label: 'Текст ссылки',
                        validate: CKEDITOR.dialog.validate.notEmpty("Введите текст для ссылки")
                    },
                    /*{
                        type: 'html',
                        html: '<a href="/admin/content/files/add/">Загрузить файлы можно здесь</a>'
                    }*/
                ]
            }
        ],
        onOk: function () {
            var dialog = this;

            var file = editor.document.createElement('a');
            file.setAttribute('title', dialog.getValueOf('tab-basic', 'title'));
            file.setAttribute('href', dialog.getValueOf('tab-basic', 'href'));
            file.setText(dialog.getValueOf('tab-basic', 'title'));

            editor.insertElement(file);
        }
    };
});
