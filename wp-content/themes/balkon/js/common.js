

$(document).ready(function(){

    $('.az-select').each(function(){
        var select = $(this);    
        var option = select.find('select option');
        var str = '<div class="az-options">';
        select.find('option').each(function(){
            str+= '<div data-val="' +$(this).val() + '">' + $(this).text() + '</div>'
        });
        str+= '</div>';
        select.html(select.html() + str);

        select.find('select').mousedown(function(){
            return false;
        });
        select.mouseup(function(){
            select.find('select').focus();
        });
        select.find('.az-options div[data-val]').click(function(){
            select.find('select').val($(this).attr('data-val'));
        });
        select.find('select').focusout(function(){
            if(!select.is(':hover')){
                select.find('.az-options').slideUp(0);
                select.removeClass('az-select-focus');
            }
        });
    });

    $(".az-select").click(function(){
        $(this).find('.az-options').slideToggle(0);
        $(this).toggleClass('az-select-focus');
    });



    $('.dfnavlink').on('click' , function(e){
        e.preventDefault();
        var thishref = $(this).attr('href');
        $('.dfnavtab').find('.dfactivelink').removeClass('dfactivelink');
        $(this).addClass('dfactivelink');
        $('.dfslider').not(thishref).css('display', 'none');
        $(thishref).css('display', 'block');


        $('.dfslider').each(function() {
           var $owlitem1 = $(thishref);
           $owlitem1.trigger('destroy.owl.carousel');

           $owlitem1.html($owlitem1.find('.owl-stage-outer').html()).removeClass('owl-loaded');
           $owlitem1.owlCarousel({                           
            loop:true,
            nav:true, 
            autoplay:false,
            smartSpeed:1000,
            margin:15,    
            navText:['<span class="df-left"></span>','<span class="df-right"></span>'],
            responsive:{
                0:{
                    items:1
                },
                410:{
                    items:1   
                },        
                700:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });   

       });
    });
    $('.dfnavlink:first').click();


    $('.dfnavlink2').on('click' , function(e){
        e.preventDefault();
        var thishref = $(this).attr('href');
        $('.dfnavtab2').find('.dfactivelink').removeClass('dfactivelink');
        $(this).addClass('dfactivelink');
        $('.dfslider2').not(thishref).css('display', 'none');
        $(thishref).css('display', 'block');


        $('.dfslider2').each(function() {
           var $owlitem2 = $(thishref);
           $owlitem2.trigger('destroy.owl.carousel');

           $owlitem2.html($owlitem2.find('.owl-stage-outer').html()).removeClass('owl-loaded');
           $owlitem2.owlCarousel({                           
            loop:true,
            nav:true, 
            autoplay:false,
            smartSpeed:1000,
            margin:15,    
            navText:['<span class="df-left"></span>','<span class="df-right"></span>'],
            responsive:{
                0:{
                    items:1
                },
                410:{
                    items:1   
                },        
                700:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });   
       }); 
    });
    $('.dfnavlink2:first').click();



    var owl1 = $(".dfcarousel1");
    owl1.owlCarousel({
        loop:true,
        nav:true, 
        autoplay:false,
        smartSpeed:1000,
        margin:25,
        mouseDrag:false,
        touchDrag: false,
        center:false,     //если нужны обрезаные края
        navText:['<span class="df-left"></span>','<span class="df-right"></span>'],
        responsive:{
            0:{
                items:1
            },
            410:{
                items: 2   
            },        
            900:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });

    var owl2 = $(".dfcarousel2");
    owl2.owlCarousel({
        loop:true,
        nav:true, 
        autoplay:false,
        smartSpeed:1000,
        margin:25,
        mouseDrag:false,
        touchDrag: false,
        center:false,     //если нужны обрезаные края
        navText:['<span class="df-left"></span>','<span class="df-right"></span>'],
        responsive:{
            0:{
                items:1
            },
            410:{
                items: 2   
            },        
            900:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });

    var owl3 = $(".dfcarousel3");
    owl3.owlCarousel({
        loop:true,
        nav:true, 
        autoplay:false,
        smartSpeed:1000,
        margin:25,
        mouseDrag:false,
        touchDrag: false,
        center:false,     //если нужны обрезаные края
        navText:['<span class="df-left"></span>','<span class="df-right"></span>'],
        responsive:{
            0:{
                items:1
            },
            410:{
                items: 2   
            },        
            900:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });

    $('.js-but').click(function(){
        $('#js-menu').slideToggle(500);
    });

});


