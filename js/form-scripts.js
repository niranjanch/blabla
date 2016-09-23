var count = 0;      // Declaring and defining global increment variable.
var fileHeaders = [];
// Following function will executes on change event of file input to select different file.
// Add events
$('input[type=file]').on('change', fileUpload);
function fileUpload(event){
console.log('file changed');
console.log(this);
	var file = this.files[0];
	var formData = new FormData();
	formData.append('file', file);

	$.ajax({
        type: "POST",
        url: "php/form-process.php",
	data: formData,
    	contentType: false,
    	processData: false,
        success : function(data){
                var Jdata = $.parseJSON(data);
                if (Jdata.length > 0)
                {
            		// Incrementing global variable by 1.
                    count += 1; 
                    if(count <= 1)
                    {
                		var options = '';	
                		$('#content').append('<div class="form-group col-sm-6"><label class="col-sm-4 control-label" for="file_option'+count+'" >'+Jdata[0]+'</label><div id="file_option'+count+'"></div>');
                		var output='<input type="hidden" name="files['+count+']" value="'+Jdata[0]+'" /><input type="hidden" name="file_names['+count+']" value="'+Jdata[0]+'" />';
                		var str1 =
                		    '<div class="col-sm-5"><select id="file_names'+count+'" class="form-control" name="file_headers['+count+']" required >'+
                		    '<option >Select Header</option>';
                		output = output + str1;
                		for (var i=0;i<Jdata[1][0].length;i++){
                		    output = output + '<option value="'+Jdata[1][0][i]+'">'+Jdata[1][0][i]+'</option>';
                		}
                		$('#file_option'+count).append(output + '</select></div></div>');
                    }
                    else if(count == 2)
                    {
                        var options = '';   
                        $('#content').append('<div class="form-group col-sm-6"><div class="col-sm-5" ><input type="hidden" name="files['+count+']" value="'+Jdata[0]+'" /><select name="file_names['+count+']" id="file_names'+count+'" class="form-control file_names" onchange="loadHeaders(this,'+count+')"></select></div><div class="col-sm-5"><select name="file_headers['+count+']" class="form-control" id="file_headers'+count+'" ></select></div></div>');
                        $('.file_names').append('<option value="-1">Select File</option><option value="'+ Jdata[0] + '" >'+ Jdata[0] +'</option>');
                        fileHeaders[Jdata[0]] = [];
                        var output = '';
                        for (var i=0;i<Jdata[1][0].length;i++){
                            output = output + '<option value="'+Jdata[1][0][i]+'">'+Jdata[1][0][i]+'</option>';
                        }
                        fileHeaders[Jdata[0]] = output;

                        // $('#content').append('<div class="form-group col-sm-6"><label class="col-sm-4 control-label" for="file_option'+count+'" >'+Jdata[0]+'</label><div id="file_option'+count+'"></div>');
                        // var output='<input type="hidden" name="file_names['+count+']" value="'+Jdata[0]+'" />';
                        // var str1 =
                        //     '<div class="col-sm-5"><select id="file_names'+count+'" class="form-control" name="file_headers['+count+']" required >'+
                        //     '<option >Select Header</option>';
                        // output = output + str1;
                        // for (var i=0;i<Jdata[1][0].length;i++){
                        //     output = output + '<option value="'+Jdata[1][0][i]+'">'+Jdata[1][0][i]+'</option>';
                        // }
                        // $('#file_option'+count).append(output + '</select></div></div>');
                    }
                    else
                    {
                        var file_name = $('input[name=files['+(count-1)+']').val();
                        $('#content').append('<div class="form-group col-sm-6"><label class="col-sm-4 control-label">'+file_name+
                                '</label><input type="hidden" name="file_names['+count+']" value="'+file_name+
                                '"><div class="col-sm-5"><select id="file_headers'+count+'" class="form-control" name="file_headers['+count+']" ></select></div></div>');
                        var options = '';   
                        $('#content').append('<div class="form-group col-sm-6"><label class="col-sm-4 control-label" for="file_option'+count+'" >'+Jdata[0]+'</label><div id="file_option'+count+'"></div>');
                        var output='<input type="hidden" name="file_names['+count+']" value="'+Jdata[0]+'" />';
                        var str1 =
                            '<div class="col-sm-5"><select id="file_names'+count+'" class="form-control" name="file_headers['+count+']" required >'+
                            '<option >Select Header</option>';
                        output = output + str1;
                        for (var i=0;i<Jdata[1][0].length;i++){
                            output = output + '<option value="'+Jdata[1][0][i]+'">'+Jdata[1][0][i]+'</option>';
                        }
                        $('#file_option'+count).append(output + '</select></div></div>');
                    }
                }
                else {
                    formError();
                    submitMSG(false,data);
                }
        }
    });
}

// Set the options to class
function loadHeaders(selected,cnt)
{
    if(selected.value != '-1')
    {
        $('#file_headers'+cnt).append('<option >Select Header</option>'+fileHeaders[selected.value]);
    }else{
        $('#file_headers'+cnt).html('<option >Select File First</option>');
    }
}

function formSuccess(){
//$("#first_file").empty();
//$("#file1").attr('disabled', 'disabled');
//$('#myDiv').html("<label for='name' class='h4'>Select Next File</label><input type='file' name='file'onchange='fileUpload()'/>");
}


function formError(){
    $("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass();
    });
}

function submitMSG(valid, msg){
    if(valid){
        var msgClasses = "h3 text-center tada animated text-success";
    } else {
        var msgClasses = "h3 text-center text-danger";
    }
    $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
}


