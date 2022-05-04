$('#send_message').click(function(){
	var chat_room_id = $('#chat_room_id').val();
	var message = $('#message').val();
	 document.getElementById('message').value = '';
		if(message == ''){
			document.getElementById('sending').innerHTML = 'Empty message not allow please write something';
		} else if(chat_room_id == ''){
			document.getElementById('sending').innerHTML = 'We can not send this message please try after sometime';
		} else {
			document.getElementById('sending').innerHTML = 'Sending...';
		var data_string = 'chat_room_id='+chat_room_id+'&message='+message;
		//alert(data_string);
		$.ajax({
			
			type : 'post',
	        data : data_string,
	        url : base_url+'professional/ProChats/send_message',

	        success:function(response){
	            var result = JSON.parse(response);
	            if(result.status==="failed"){
	                var data = '';
	                data = '<option value="">'+result.message+'</option>';
	                $("#chats").html(data);
	            }else{
	            	
	            	document.getElementById('sending').innerHTML = '';
	            	$('.margins').innerHTML = '<div class="mb-10 margin" ></div>';
					$("#mydiv").load(" #mydiv");
					//$("#chat_div").scrollTop($('#chat_div')[0].scrollHeight);
					$("#chat_div").animate({ scrollTop: $('#chat_div')[0].scrollHeight }, "slow");
  					return false;
					
    				
	            }
	        }
		})
	}
})


$('.confirmbox').click(function(event){
	 event.preventDefault(); // 
	 var url = $(this).attr('href');
	swal({
	  title: "Are you sure to complete?",
	  text: "Please make sure you have verified all the tasks before marking it complete. This process can not be reverted. Are you sure to complete?",
	  icon: "warning",
	  buttons: true,
	  dangerMode: true,
	})
	.then((willDelete) => {
	  if (willDelete) {
	    window.location.href = url;
	   
	  } else {
	   	return false;
	  }
	});
});


$('.confirmfornotarrived').click(function(event){
	 event.preventDefault(); // 
	 var url = $(this).attr('href');
	swal({
	  title: "Are you sure to report?",
	  text: "Administrator and the provider will be notified for this report.",
	  icon: "warning",
	  buttons: true,
	  dangerMode: true,
	})
	.then((willDelete) => {
	  if (willDelete) {
	    window.location.href = url;
	   
	  } else {
	   	return false;
	  }
	});
}); 



$('.confirmcancel').click(function(event){
	 event.preventDefault(); // 
	 var url = $(this).attr('href');
	swal({
	  title: "Are you sure ?",
	  text: "You want to cancel the request.",
	  icon: "warning",
	  buttons: true,
	  dangerMode: true,
	})
	.then((willDelete) => {
	  if (willDelete) {
	    window.location.href = url;
	   
	  } else {
	   	return false;
	  }
	});
}); 
