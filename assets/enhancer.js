/*global $: false, editor: false, languageTag: false, rootURI: false,
window: false, programSelect: false, poolSelect: false, teacherSelect: false,
englishText: false, germanText: false*/

/**
 * Changes the language settings for subjects
 * 
 * @returns {void}
 */
function changeLanguage()
{
    "use strict";
    var queryParameters = {}, queryString = location.search.substring(1),
        re = /([^&=]+)=([^&]*)/g, temp;

    temp = re.exec(queryString);
    while (temp)
    {
        queryParameters[decodeURIComponent(temp[1])] = decodeURIComponent(temp[2]);
        temp = temp = re.exec(queryString);
    }

    if (languageTag === 'de')
    {
        queryParameters.languageTag = 'en-GB';
    }
    else
    {
        queryParameters.languageTag = 'de-DE';
    }
    location.search = $.param(queryParameters);
}

/**
 * Clear the current list and add new pools to it
 * 
 * @param   {object}  pools   the pools recieved
 * @param   {string}  poolID  the id of the last selected pool
 */
function addPools(pools, poolID)
{
    "use strict";

    var poolSelection = $('#poolID'), poolDiv = $('.poolID');

    poolSelection.children().remove();

    if (pools.length === 0) {
        poolDiv.hide();
        return;
    }

    poolDiv.show();

    poolSelection.append('<option value="-1">' + poolSelect + '</option>');
    $.each(pools, function (key, value) {
        var selected = '';
        if (value.id === poolID) { selected += 'selected'; }
        poolSelection.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
    });
}

/**
 * Load pool data for the selected program & teacher
 */
function repopulatePools()
{
    "use strict";

    var poolID = $('#poolID').val(), componentParameters, selectionParameters;
    componentParameters = 'index.php?option=com_thm_organizer&view=pool_ajax&format=raw&task=poolsByProgramOrTeacher';
    selectionParameters = '&programID=' + $('#programID').val();
    selectionParameters += '&teacherID=' + $('#teacherID').val();
    selectionParameters += '&languageTag=' + languageTag;
    $.ajax({
        type: 'GET',
        url: rootURI + componentParameters + selectionParameters,
        dataType: 'json',
        success: function (data) {addPools(data, poolID); },
        error: function (xhr, textStatus, errorThrown) {
            if (xhr.status === 404 || xhr.status === 500) {
                $.ajax(repopulatePools());
            }
        }
    });
}

/**
 * Clear the current list and add new teachers to it
 * 
 * @param   {object}  teachers   the teachers recieved
 * @param   {string}  teacherID  the id of the last selected teacher
 */
function addTeachers(teachers, teacherID) {
    "use strict";

    var teacherSelection = $('#teacherID'), teacherDiv = $('.teacherID');

    teacherSelection.children().remove();

    if (Array.isArray(teachers)) {
        teacherDiv.show();
    } else {
        teacherDiv.hide();
        return;
    }

    teacherSelection.append('<option value="-1">' + teacherSelect + '</option>');
    $.each(teachers, function (key, value) {
        var selected = '';
        if (value.id === teacherID) { selected += 'selected'; }
        teacherSelection.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
    });
}

/**
 * Load teacher data for the selected program/pool
 */
function repopulateTeachers() {
    "use strict";

    var teacherID = $('#teacherID').val(), componentParameters, selectionParameters;
    componentParameters = 'index.php?option=com_thm_organizer&view=teacher_ajax&format=raw&task=teachersByProgramOrPool';
    selectionParameters = '&programID=' + $('#programID').val();
    selectionParameters += '&poolID=' + $('#poolID').val();
    $.ajax({
        type: 'GET',
        url: rootURI + componentParameters + selectionParameters,
        success: function (data) { addTeachers($.parseJSON(data), teacherID); },
        error: function (xhr, textStatus, errorThrown) {
            if (xhr.status === 404 || xhr.status === 500) {
                $.ajax(repopulateTeachers());
            }
        }
    });
}

/**
 * Clear the current list and add new programs to it
 * 
 * @param   {object}  programs   the programs recieved
 * @param   {string}  programID  the id of the last selected program
 */
function addPrograms(programs, programID) {
    "use strict";

    var programSelection = $('#programID');

    programSelection.children().remove();

    programSelection.append("<option value=\"-1\">" + programSelect + "</option>");
    $.each(programs, function (key, value) {
        var selected = '';
        if (value.id === programID) { selected += 'selected'; }
        programSelection.append("<option value=\"" + value.id + "\" " + selected + ">" + value.name + "</option>");
    });
}

/**
 * Load program data for the selected teacher
 */
function repopulatePrograms() {
    "use strict";

    var programID = $('#programID').val(), componentParameters, selectionParameters;
    componentParameters = 'index.php?option=com_thm_organizer&view=program_ajax&format=raw&task=programsByTeacher';
    selectionParameters = '&teacherID=' + $('#teacherID').val();
    selectionParameters += '&languageTag=' + languageTag;
    $.ajax({
        type: 'GET',
        url: rootURI + componentParameters + selectionParameters,
        dataType: 'json',
        success: function (data) {addPrograms(data, programID); },
        error: function (xhr, textStatus, errorThrown) {
            if (xhr.status === 404 || xhr.status === 500) {
                $.ajax(repopulatePrograms());
            }
        }
    });
}

/**
 * Clear the current list and add new subjects to it
 * 
 * @param   {object}  subjects  the subjects recieved
 */
function addSubjects(subjects) {
    "use strict";

    $('#selectable').children().remove();

    if (!Array.isArray(subjects)) {
        return;
    }

    var rowID = 0;
    $.each(subjects, function (key, value) {
        var html, rowClass = 'row' + rowID % 2;
        if (value.externalID !== 'null' && value.externalID !== null && value.externalID !== '') {
            value.externalID = ' (' + value.externalID + ')';
        } else {
            value.externalID = '';
        }
        html = '<tr id="' + rowID + '" class="' + rowClass + '"><td style="text-align: left">';
        html += '<input type="checkbox" id="cb' + rowID + '" value="' + value.id + '">';
        html += '<span id="subject' + rowID + '">' + value.name + value.externalID + '</span>';
        html += '</td></tr>';
        $(html).appendTo('#selectable');
        rowID = rowID + 1;
    });
}

/**
 * Load subject data for the selected filter criteria
 */
function repopulateSubjects() {
    "use strict";

    var componentParameters, selectionParameters;
    componentParameters = 'index.php?option=com_thm_organizer&view=subject_ajax&format=raw&task=getSubjects';
    selectionParameters = '&programID=' + $('#programID').val();
    selectionParameters += '&poolID=' + $('#poolID').val();
    selectionParameters += '&teacherID=' + $('#teacherID').val();
    selectionParameters += '&languageTag=' + languageTag;
    $.ajax({
        type: 'GET',
        url: rootURI + componentParameters + selectionParameters,
        success: function (data) {addSubjects($.parseJSON(data)); },
        error: function (xhr, textStatus, errorThrown) {
            if (xhr.status === 404 || xhr.status === 500) {
                $.ajax(repopulateSubjects());
            }
        }
    });
}

/**
 * Inserts the selected subjects into the editor as links
 * 
 * @returns {void}
 */
function insertSubjects() {
    "use strict";

    var subjects = '',
        link = 'index.php?option=com_thm_organizer&view=subject_details&languageTag=';
    $.each($('#selectable input'), function (key, value) {
        var subjectLink, checked = value.checked, subjectID = value.value, subject = $('#subject' + key).text();

        subjectLink = link + languageTag + '&id=' + subjectID;
        if (checked) {
            subjects += '<a target="_blank" href="' + subjectLink + '">' + subject + '</a><br />';
        }
    });
    window.parent.jInsertEditorText(subjects, editor);
    window.parent.SqueezeBox.close();
}
