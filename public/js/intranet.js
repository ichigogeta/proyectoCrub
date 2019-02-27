function tinymce_init_callback(editor) {
    editor.remove();
    editor = null;
    tinymce.init({
        menubar: false,
        selector: 'textarea.richTextBox',
        language: 'es',
        skin: 'voyager',
        min_height: 600,
        resize: 'vertical',
        plugins: 'link, image, code, youtube, giphy, table, textcolor, lists',
        extended_valid_elements: 'input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]',
        file_browser_callback: function (field_name, url, type, win) {
            if (type == 'image') {
                $('#upload_file').trigger('click');
            }
        },
        toolbar: 'styleselect fontsizeselect bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | link image table youtube giphy | code',
        convert_urls: false,
        image_caption: true,
        image_title: true,
        table_default_styles: {
            'border-collapsed': 'collapse',
            'width': '100%'
        },
        table_responsive_width: true

    });

    //visualblocks y otros plugins tienen el nombre cambiado.
}
