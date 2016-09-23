var abc = 0;      // Declaring and defining global increment variable.
$(document).ready(function() {
//  To add new input file field dynamically, on click of "Add More Files" button below function will be executed.
$('#add_more').click(function() {
$(this).before($("<div/>", {
id: 'filediv'
}).fadeIn('slow').append($("<input/>", {
name: 'file[]',
type: 'file',
id: 'file'
}), $("<br/><br/>")));
});
// Following function will executes on change event of file input to select different file.
// Add events
$('input[type=file]').on('change', fileUpload);
function fileUpload(event){
files = event.target.files;
console.log(files);
}

// To Preview Image
function imageIsLoaded(e) {
console.log(e.target.result);
//$('#previewimg' + abc).attr('src', e.target.result);

};
$('#upload').click(function(e) {
var name = $(":file").val();
if (!name) {
alert("First Image Must Be Selected");
e.preventDefault();
}
});
//show the file name
function setfilename(val)
{
    var fileName = val.substr(val.lastIndexOf("\\")+1, val.length);
    $('#previewimg' + abc).value = fileName;
}

});
