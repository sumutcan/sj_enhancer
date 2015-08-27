/*global $: false, editor: false, languageTag: false, rootURI: false,
window: false, programSelect: false, poolSelect: false, teacherSelect: false,
englishText: false, germanText: false*/



/**
 * Inserts the selected subjects into the editor as links
 * 
 * @returns boolean
 */
function insertEnhancements() {
    "use strict";

    var link = 'index.php?option=com_thm_groups&view=profile&layout=default&';
    var content;
    var editorArea = $('#jform_articletext', window.parent.document)[0];
    var entities = [];
    content = editorArea.value;
    $.each($('#selectable input'), function (key, value) {
        var subjectLink, checked = value.checked, subject = $('#subject' + key).text();

        if (checked) {

            var chkArray = value.value.split('-');
            var entityID = chkArray[0];
//            var ranges = chkArray[1].split(';');
            var selectedText = chkArray[2];
//            var start = ranges[0].split(',')[0];
//            var end = ranges[0].split(',')[1];

            subjectLink = link + 'gsuid=' + entityID;

            content = content.replace(selectedText, '<a target="_blank" href="' + subjectLink + '">' + selectedText + '</a>');
            entities.push(entityID);
        }
    });
    var postData = JSON.stringify(entities);
    $.ajax({
        data:{entities: postData},
        url:"manage_session.php",
        type: "POST",
        success:function(result){

            console.log(result);
            window.parent.WFEditor.setContent(editor,content);
            window.parent.SqueezeBox.close();
        },
        error:function(error)
        {
            alert(error);
        }
    });


    return false;
}

