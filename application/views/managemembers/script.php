    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<!--Start validation-->
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<!--End validation-->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!--Start toast-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script type="text/javascript">
		toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": false,
				"progressBar": true,
				"preventDuplicates": true,
				"onclick": null,
				"showDuration": "100",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "show",
				"hideMethod": "hide"
			};
	</script>
	<!--End toast-->

<script type="text/javascript">
function showAddMember(){
     $.ajax({
        type: 'POST',
        url: '<?php echo BASE_HREF; ?>managememberscontroller/showAddMemberForm',
        dataType: 'html',
        success: function(data){
			$('#myModal').modal('show');
		   	$('#showAddMember').html(data);
		 }
	});
 }
</script>
<script type="text/javascript">
       function addMember() {
           $("#newMemberForm").validate({
              rules: {
                    memname: {
                    	  required: true,
						  lettersonly: true,
                   	},
                },
                messages: {
                    memname: {
                          required: "Please Enter Name",
						  lettersonly: "Please Enter Only Character",
                    }
                 },
                 errorPlacement: function(error, element) {
  			        if(element.attr("name") == "memname") {
	                      error.appendTo($('#memnamemsg'));
					}
                 },
                 submitHandler: function(form) {
                    addMemberForm();
                 }
            });
       }
       var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
       jQuery.validator.addMethod("specialChar", function(value, element) {
          			return this.optional(element) || re.test(value);
       }, "Please enter valid email address");

        function addMemberForm() {
           	var form = $("#newMemberForm");
            $.ajax({
                    type: 'POST',
                    url: '<?php echo BASE_HREF; ?>managememberscontroller/postAddMembersFormData',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(data) {
                            if(data['error'] == 1) {
								$('#myModal').modal('hide');
                                toastr.success(data['msg']);
								var pid = data['pid'];
								var cid = data['cid'];
								if(data['flag'] == 1) {
									$('#u-'+pid).append("<li id='l-"+cid+"'>"+data['pname']+"</li>");
								} else if(data['flag'] == 2) {
									$('#l-'+pid).append("<ul id='u-"+pid+"'><li id='l-"+cid+"'>"+data['pname']+"</li></ul>");
								} else {
									$('#u-'+pid).append("<li id='l-"+cid+"'>"+data['pname']+"</li>");
								}
                            }
                            else {
                                toastr.error(data['msg']);
                            }
                    }
            });
        }
</script>
</body>
</html>
