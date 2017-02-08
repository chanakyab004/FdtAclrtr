$(document).ready(function() {
	$('#notifications').hover(getNotifications);	
});


	
	var getNotifications = function() {
		if (!$('#notificationList ul').hasClass('notifications-loaded')) {
			$.ajax({
				url: 'getNotifications.php',
				dataType: "json",
				contentType: 'application/json',
				type: "GET",
				contentType: "application/x-www-form-urlencoded",
				success: function(response) {
					$.each(response, function (i, item) {
						 if(i>9) return false;
						$('#notificationList ul').append('<li><a href="'+item.link+'"><strong>'+item.firstName+' '+item.lastName+'</strong><br/>'+item.notificationType+'<br/><span>'+item.time+'</span></a></li>');
					});
					
					if (response.length > 0){
						$('#notificationList ul').append('<li><a id="allNotifications">View All</a></li>');
					}
					else{
						$('#notificationList ul').append('<li><a>No Notifications to Display</a></li>');
					}
					
					
					$('#allNotifications').click(function(){ 
						//Open Notifications Modal
						$('#notificationsModal').foundation('open');
						getNotificationsModal();
					});
					
					$('#notificationList ul').addClass('notifications-loaded');
							
				}, error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
					console.log(jqXHR.responseText);
				}
			
			});	
		
		}
	};
	
	var getNotificationsModal = function() {
		if (!$('#notificationsModal ul').hasClass('notifications-loaded')) {
			$.ajax({
				url: 'getNotifications.php',
				dataType: "json",
				contentType: 'application/json',
				type: "GET",
				contentType: "application/x-www-form-urlencoded",
				success: function(response) {
					$.each(response, function (i, item) {
						$('#notificationsModal ul').append('<li><a href="'+item.link+'"><strong>'+item.firstName+' '+item.lastName+'</strong><br/>'+item.notificationType+'<br/><span>'+item.time+'</span></a></li>');
					});
					
					$('#notificationsModal ul').addClass('notifications-loaded');
							
				}, error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
					console.log(jqXHR.responseText);
				}
			
			});	
		
		}
	};
