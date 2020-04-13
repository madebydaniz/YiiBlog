(function($) {
    "use strict";

    var loading = false;

    $(document).ready(function(){

        $("#txt_search").keyup(function(){
            var keyword = $(this).val();
            var searchResult = $("#searchResult");
            if(keyword !== "") {
                $.ajax({
                    url: '/api/search/',
                    type: 'get',
                    data: {keyword:keyword},
                    dataType: 'json',
                    success:function(response) {

                        var len = response.length;

                        searchResult.empty();

                        for( var i = 0; i<len; i++)
                        {
                            var title = response[i]['title'];
                            var slug = response[i]['slug'];
                            searchResult.append("<li value='"+slug+"'>"+title+"</li>");
                        }
                        searchResult.find('li').bind("click",function(){
                            var slug = $(this).attr('value');
                            window.location = window.location.origin + '/post/' + slug;
                        });
                    }
                });
            }
            if (keyword === "") {
                searchResult.empty();
            }
        });

        $(document).on('click','.df-load-more:not(.loading)', function(){

            getNewPage();

        });

        $(window).scroll(function () {
            if ($(window).scrollTop() == $(document).height() - $(window).height() )
            {
                getNewPage();
            }
        });
        
        function getNewPage() {
            if (loading == false) {
                loading = true;
                var that = $('.df-load-more');
                var page = $('.df-load-more').data('page');
                var newPage = page+1;

                that.addClass('loading').find('.text').slideUp(320);
                that.find('.sunset-icon').addClass('spin');

                $.ajax({

                    url : '/api/getpost/',
                    type : 'get',
                    data : {
                        pagenumber : page
                    },
                    error : function( response ){
                        console.log(response);
                    },
                    success : function( response ){

                        if( response == 0 ){

                            $('#ajax-posts-container').append( '<div class="text-center"><h3>You reached the end of the line!</h3><p>No more posts to load.</p></div>' );
                            that.slideUp(320);

                        } else {

                            setTimeout(function(){

                                $('#ajax-posts-container').append(response);
                                loading = false;

                                if( newPage == 1 ){

                                    that.slideUp(320);

                                } else {

                                    that.data('page', newPage);
                                    that.removeClass('loading').find('.text').slideDown(320);
                                    that.find('.sunset-icon').removeClass('spin');
                                    var loadmore = $('.df-load-more');
                                    if (newPage > loadmore.data('totalpage')) {
                                        loadmore.parent().append( '<div class="text-center"><h3>You reached the end of the line!</h3><p>No more posts to load.</p></div>' );
                                        that.remove();
                                    }
                                }

                            }, 1000);

                        }


                    }

                });
            }

        }
    });




})( jQuery );

