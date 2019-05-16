<div class="block" >
<h3><?=$BlockHeading?></h3> 
<div class="bgwhite blockscroll" style="<?=$scrollStyle?>">



	<div id='calendar'></div>

</div>
</div>




<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='fullcalendar/fullcalendar.min.js'></script>


<script>

	$(document).ready(function() {
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();		

		//alert(date);

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: date,
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: "json-event.php",

			eventClick: function(event) {
			  if(event.url) {
			      $.fancybox({
				'href' : event.url,
				'type' : 'iframe'					 
			      });
			      return false;
			  }
			}
			/*events: [
				{
					title: 'All Day Event',
					start: '2015-06-01'
				},
				{
					title: 'Long Event',
					start: '2015-06-07',
					end: '2015-06-10'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2015-06-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2015-06-16T16:00:00'
				},
				{
					title: 'Conference',
					start: '2015-06-11',
					end: '2015-06-13'
				},
				{
					title: 'Meeting',
					start: '2015-06-12T10:30:00',
					end: '2015-06-12T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2015-06-12T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2015-06-12T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2015-06-12T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2015-06-12T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2015-06-13T07:00:00'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2015-06-28'
				}
			]*/
		});
		

		
	});

</script>
