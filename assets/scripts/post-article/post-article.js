
// editor config e instancia
const easyMDE = new EasyMDE({
    element: document.getElementById('body'),
    placeholder: "Escribe lo que tienes para compartir...",
    autofocus: false,
        autosave: { //Delay between saves, in milliseconds.
            enabled: true,
            uniqueId: "MyUniqueID",
            delay: 1000, //1s
            submit_delay: 5000, // if the subit failed, 0.5s to save
            timeFormat: {
                locale: 'es-MX',
                format: {
                    year: 'numeric',
                    month: 'short',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                },
            },
            text: "Autosaved: "
        },
        unorderedListStyle: "-", //change por *
        forceSync: true, //force text changes made in EasyMDE to be immediately stored in original text area.
        // insertTexts: {
        //     horizontalRule: ["", "\n\n-----\n\n"],
        //     image: ["![](http://", ")"],
        //     link: ["[", "](https://)"],
        //     table: ["", "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text     | Text      | Text     |\n\n"],
        // }
        // lineNumbers: true
        parsingConfig: {
            allowAtxHeaderWithoutSpace: true, //render header after space
            strikethrough: false,
            underscoresBreakWords: true, //3 underscores to delimited
        },
        previewClass: "my-custom-styling", //class of CSS to customized the editor-preview
        promptURLs: true, // a JS alert window appears asking for the link or image URL.
        // promptTexts: {
        //     image: "Custom prompt for URL:",
        //     link: "Custom prompt for URL:"
        // }
        uploadImage: true, //enables the image upload functionality
        imageMaxSize: 1024*1024,
        shortcuts: {
            drawTable: "Ctrl-Alt-T"
        },
        showIcons: ["code", "table"],
        spellChecker: true,
        sideBySideFullscreen: false,
        status: ["autosave", "lines", "words", "cursor"],
        syncSideBySidePreviewScroll: false,
        showIcons: ['strikethrough', 'code', 'table', 'redo', 'heading', 'undo', 'clean-block', 'horizontal-rule']
});