<?php
function render_editor($name, $value = "", $height = "300px")
{
    $id = "editor_" . $name;
?>

    <textarea id="<?= $id ?>"
        name="<?= $name ?>"
        class="w-full border p-2 rounded"><?= htmlspecialchars($value) ?></textarea>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#<?= $id ?>'), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', 'code', 'subscript', 'superscript', '|',
                        'link', 'insertTable', 'blockQuote', 'codeBlock', 'highlight', 'horizontalLine', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                        'alignment:left', 'alignment:center', 'alignment:right', 'alignment:justify', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'imageUpload', 'mediaEmbed', '|',
                        'undo', 'redo'
                    ]
                },
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                },
                mediaEmbed: {
                    previewsInData: true
                },
            })
            .then(editor => {
            })
            .catch(error => console.error(error));
    </script>

<?php
}
