CKEDITOR.plugins.add('files', {
    icons: 'files',
    requires : [ 'iframedialog' ],
    init: function (editor) {
        editor.addCommand( 'files', new CKEDITOR.dialogCommand( 'filesDialog' ) );
        editor.ui.addButton('Files', {
            label: 'Вставить файл',
            command: 'files',
            toolbar: 'insert'
        });
        CKEDITOR.dialog.add( 'filesDialog', this.path + 'dialog/files.js' );
    }
});

