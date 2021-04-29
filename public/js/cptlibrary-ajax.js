jQuery(function($){
	$(document).on('click', '.js-filter-item', function (){
		var filter = $('.js-filter');
		$.ajax({
			url:wp_ajax.ajax_url, //filter.attr('action'),
			data:filter.serialize(), // form data
			type:filter.attr('method'), // POST
			beforeSend:function(xhr){
				filter.find('button.js-filter-item').text('Processing...'); // changing the button label
			},
			success:function(data){
				filter.find('button.js-filter-item').text('Apply filter'); // changing the button label back
				$('.js-filter2').html(data); // insert data
			}
		});
		return false;
	});
});


// jQuery(function($){
// 	$(document).on('click', '.js-filter-all', function (){
// 		var filter = $('.js-filter2');
// 		$.ajax({
// 			url:wp_ajax.ajax_url, //filter.attr('action'),
// 			data:filter.serialize(), // form data
// 			type:filter.attr('method'), // POST
// 			beforeSend:function(xhr){
// 				filter.find('button').text('Processing...'); // changing the button label
// 			},
// 			success:function(data){
// 				filter.find('button').text('Apply filter'); // changing the button label back
// 				$('.js-filter2').html(data); // insert data
// 			}
// 		});
// 		return false;
// 	});
// });


// (function($){

//     $(document).ready(function(){

//         $(document).on('click', '.js-filter-item', function (e){

//             e.preventDefault();

//             var category = $(this).data('category');

//             $.ajax({
//                 url:wp_ajax.ajax_url,
//                 data:{ action: 'filter', category: category }, // form data
//                 type:'post',
//                 success:function(result){
//                     $('.js-filter').html(result); // insert data
//                 },
//                 error:function(result){
//                     console.warn(result);
//                 }
                
//             });
//         });
//     });
// })(jQuery);
