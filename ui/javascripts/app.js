$(document).ready(function(){
	
	/****Activation de ckeditor*************/	
	$("#contenu").ckeditor();
	/*****Slider des images des articles*************/
	$('.img-thumb').each(function(){
		$(this).click(function(){
			$('#image-display-layout').attr('src',$(this).attr('src'));
		});
	});
	/******L'alert des boutons d'actions************/
    $('.btn-action').each(function(){
		$(this).click(function(event){
			if($(this).attr('id')=="rm-image-link")
				str = confirm('Voulez-vous vraiment supprimer cette image ?');
			else
				str = confirm('Voulez-vous vraiment supprimer cet article ?');
			
            if(str==false)
            {
                event.preventDefault();
            }
		});
	});
	/*************************************************
	 * Récupération des coordonnées de la position
	 * courante de l'internaute
	 ****************************************/
    function showPosition(position) 
	{
        window.location.href = '/Slyboot-1.1.0/ws/location/events/'+position.coords.longitude+'/'+position.coords.latitude;
    }
    /*****************Géolocalisation********************/ 
    $("#geoevents").click(function(ev){
        
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else { 
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        
        ev.preventDefault();
    });
    /*********Sélection/déselection des images flickfr**********/
	 $('#photo-container').on('click','img.flickr-img', function () {
	    if($(this).hasClass('selected')) {
	        $(this).removeClass('selected');
	        $(this).addClass('default-border');  
	    } else {
	        $(this).removeClass("default-border"); 
		    $(this).addClass("selected");
	    }
	});
	/*******Envois des images flickr au serveur pour insertion en base*************/
	$("#flk-img-btn").click(function(event){
		
		var objContainer  = [];
		$("img.selected").each(function(){
			var obj = {src : $(this).attr("src"), title : $(this).attr("alt")};
			objContainer.push(obj);
		});
		//console.log($("#articleId").val());
		//console.log(objContainer);
		if (objContainer.length > 0) {
			$.ajax({
                url: "/Slyboot-1.1.0/image/add/"+$("#articleId").val(),
                type: "post",
                dataType: "json",
                data: {photosFlickr : objContainer}
            }).done(function(response) {
                if (response==1) {
                    window.location.href = '/Slyboot-1.1.0/article/detail/'+$("#articleId").val();
                }
				console.log(response);
			});
		}
	});
	/*******Parsage des images flickr**************/
    function parsePhotos(data)
    {
		content = "";
        data = data.photos.photo;
        for(i in data)
        {
            var src = 'https://farm' + data[i].farm + '.staticflickr.com/' + data[i].server + '/'+ data[i].id +'_'+ data[i].secret + '_q.jpg';
             content += '<img src="'+src+'" alt="' + data[i].title + '" class="flickr-img default-border"/>';
        }
        $('#photo-container').append(content);
    }
	/*******Récupération des images sur le serveur de flickr*************/
    $("#flickr-search").on('click', function(ev){
            var tag = $("#tag").val();
            var parameters = {
                    api_key:"b61984c8f8b83c6d90789912ae83737b",
                    tags : tag, 
                    format: "json",
                    privacy_filter : 1
                }
            $.ajax({
                url: "https://api.flickr.com/services/rest/?method=flickr.photos.search",
                jsonp: "jsoncallback",
                dataType: "jsonp",
                data: parameters
            }).done(parsePhotos);
            
             ev.preventDefault();
        });
});
