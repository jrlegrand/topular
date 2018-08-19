$(function(){
    // control-mode. control for top and side mode (fixed or normal), you can remove it if you want..
    var control_mode = '<div id="modal-setup" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalSetupLabel" aria-hidden="true">'
    +'        <div class="modal-header">'
    +'            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'
    +'            <h3 id="modalSetupLabel">Layout Mode & Themes</h3>'
    +'        </div>'
    +'        <div class="modal-body">'
    +'            <form>'
    +'                <div class="control-group">'
    +'                    <label class="control-label">Layout:</label>'
    +'                    <div class="controls">'
    +'                        <div class="btn-group">'
    +'                            <button id="normal-mode" type="button" class="btn btn-small btn-primary">Normal</button>'
    +'                            <button id="fixedtop-mode" type="button" class="btn btn-small btn-primary">Fixed top</button>'
    +'                            <button id="fixedside-mode" type="button" class="btn btn-small btn-primary">Fixed Side</button>'
    +'                            <button id="fixedsideonly-mode" type="button" class="btn btn-small btn-primary">Fixed Side Only</button>'
    +'                        </div>'
    +'                    </div>'
    +'                </div>'
    +'                <div class="control-group">'
    +'                    <label class="control-label">Themes:</label>'
    +'                    <div class="controls">'
    +'                        <a class="themes-changer grd-black" rel="tooltip" title="default" data-theme="" href="#"></a>'
    +'                        <a class="themes-changer grd-blue" rel="tooltip" title="blue" data-theme="blue" href="#"></a>'
    +'                        <a class="themes-changer grd-green" rel="tooltip" title="green" data-theme="green" href="#"></a>'
    +'                        <a class="themes-changer grd-orange" rel="tooltip" title="orange" data-theme="orange" href="#"></a>'
    +'                        <a class="themes-changer grd-purple" rel="tooltip" title="purple" data-theme="purple" href="#"></a>'
    +'                        <a class="themes-changer grd-purple-dark" rel="tooltip" title="purple-dark" data-theme="purple-dark" href="#"></a>'
    +'                        <a class="themes-changer grd-red" rel="tooltip" title="red" data-theme="red" href="#"></a>'
    +'                        <a class="themes-changer grd-sky" rel="tooltip" title="sky" data-theme="sky" href="#"></a>'
    +'                        <a class="themes-changer grd-win8" rel="tooltip" title="win8" data-theme="win8" href="#"></a>'
    +'                    </div>'
    +'                </div>'
    +'                <div class="control-group">'
    +'                    <label class="control-label">Header & Side:</label>'
    +'                    <div class="controls">'
    +'                        <div class="btn-group">'
    +'                            <button id="themes-mode-default" type="button" class="btn btn-small btn-primary">Default</button>'
    +'                            <button id="themes-mode-light" type="button" class="btn btn-small btn-primary">Light</button>'
    +'                            <button id="themes-mode-dark" type="button" class="btn btn-small btn-primary">Dark</button>'
    +'                        </div>'
    +'                    </div>'
    +'                </div>'
    +'            </form>'
    +'        </div>'
    +'        <div class="modal-footer">'
    +'            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>'
    +'        </div>'
    +'    </div>'
    +'<div class="control-mode" id="control-mode">'
    +'    <div class="navigate-mode"><a href="#modal-setup" role="button" data-toggle="modal" class="grd-black corner-bottom"><i class="icon-white icon-cog"></i></a></div>'
    +'</div>';
    
    
    $('body').append(control_mode)
    
    // theme mode
    $(window).load(function () {
        setTimeout(function () {
            if(sessionStorage.theme_mode == undefined){
                sessionStorage.theme_mode = '';
            }
            // theme setting
            if(sessionStorage.themes == undefined){
                sessionStorage.themes = '';
            }
            
            if(sessionStorage.themes == ''){
                $('#style-base').attr('href', 'css/stilearn.css');
                $('#style-responsive').attr('href', 'css/stilearn-responsive.css');
                $('#style-helper').attr('href', 'css/stilearn-helper.css');
                $('#style-calendar').attr('href', 'css/fullcalendar.css');
            }
            else{
                themes = sessionStorage.themes;
                theme_mode = sessionStorage.theme_mode;

                $('#style-base').attr('href', 'css/themes/'+themes+'/stilearn.css');
                $('#style-responsive').attr('href', 'css/themes/'+themes+'/stilearn-responsive.css');
                $('#style-helper').attr('href', 'css/themes/'+themes+'/stilearn-helper.css');
                $('#style-calendar').attr('href', 'css/themes/'+themes+'/fullcalendar.css');

                // add usage theme mode
                $('header.header, .side-left').addClass(theme_mode);
            }
        }, 100);
    })
    
    $('.themes-changer').click(function(e){
        
        $this = $(this);
        data_themes = $this.attr('data-theme');
        sessionStorage.themes = data_themes;
        
        if(data_themes == ''){
            $('#style-base').attr('href', 'css/stilearn.css');
            $('#style-responsive').attr('href', 'css/stilearn-responsive.css');
            $('#style-helper').attr('href', 'css/stilearn-helper.css');
            
            // plugin theme, (custom your plugin)
            $('#style-calendar').attr('href', 'css/fullcalendar.css');
        }
        else{
            $('#style-base').attr('href', 'css/themes/'+data_themes+'/stilearn.css');
            $('#style-responsive').attr('href', 'css/themes/'+data_themes+'/stilearn-responsive.css');
            $('#style-helper').attr('href', 'css/themes/'+data_themes+'/stilearn-helper.css');
            $('#style-calendar').attr('href', 'css/themes/'+data_themes+'/fullcalendar.css');
        }
        
        e.preventDefault();
    });
    
    $('#themes-mode-default').click(function(e){
        
        $('header.header, .side-left').removeClass('dark light');
        sessionStorage.theme_mode = '';
        
        e.preventDefault();
    });
    $('#themes-mode-light').click(function(e){
        
        $('header.header, .side-left').removeClass('dark light');
        $('header.header, .side-left').addClass('light');
        sessionStorage.theme_mode = 'light';
        
        e.preventDefault();
    });
    $('#themes-mode-dark').click(function(e){
        
        $('header.header, .side-left').removeClass('dark light');
        $('header.header, .side-left').addClass('dark');
        sessionStorage.theme_mode = 'dark';
        
        e.preventDefault();
    });
    // end theme setting
    
    // control mode
    if(sessionStorage.mode == undefined){
        sessionStorage.mode = 1;
    }
    
    $('html').on('click', function(){
        $('#control-mode .choice-mode').slideUp(); // toggle slide hide
    });
    $('#normal-mode').click(function(){
        $('.header, .side-left, .side-right').removeClass('fixed');
        
        // set position by default
        $('.header').css({
            'top' : '0px'
        });
        $('.side-left, .side-right').css({
            'top' : '60px'
        });
        
        $('#control-mode .choice-mode').slideToggle(); // toggle slide hide
        
        sessionStorage.mode = 1;
        return false;
    });
    $('#fixedtop-mode').click(function(){
        $('.header, .side-left, .side-right').removeClass('fixed'); // remove first to normalize class
        $('.header').addClass('fixed');
        
        // set position by default
        $('.header').css({
            'top' : '0px'
        });
        $('.side-left, .side-right').css({
            'top' : '60px'
        });
        
        $('#control-mode .choice-mode').slideToggle(); // toggle slide hide
        
        sessionStorage.mode = 2;
        return false;
    });
    $('#fixedside-mode').click(function(){
        $('.header, .side-left, .side-right').removeClass('fixed'); // remove first to normalize class
        $('.header, .side-left, .side-right').addClass('fixed');
        
        // set position by default
        $('.header').css({
            'top' : '0px'
        });
        
        $('.side-left, .side-right').css({
            'top' : '60px'
        });
        
        $('#control-mode .choice-mode').slideToggle(); // toggle slide hide
        
        sessionStorage.mode = 3;
        return false;
    });
    $('#fixedsideonly-mode').click(function(){
        $('.header, .side-left, .side-right').removeClass('fixed'); // remove first to normalize class
        $('.side-left, .side-right').addClass('fixed');
        
        // set position by default
        if($(window).scrollTop() > 60){
            $('.side-left, .side-right').css({
                'top' : '0px'
            });
        }
            
        $('#control-mode .choice-mode').slideToggle(); // toggle slide hide
        
        sessionStorage.mode = 4;
        return false;
    });
    
    if(sessionStorage.mode){
        if(sessionStorage.mode == '1'){ // normal mode
            $('.header, .side-left, .side-right').removeClass('fixed');
        }
        if(sessionStorage.mode == '2'){ // fixed header only
            $('.header, .side-left, .side-right').removeClass('fixed'); // remove first to normalize class
            $('.header').addClass('fixed');
        }
        if(sessionStorage.mode == '3'){ // fixed all
            $('.header, .side-left, .side-right').removeClass('fixed'); // remove first to normalize class
            $('.header, .side-left, .side-right').addClass('fixed')
        }
        if(sessionStorage.mode == '4'){ // fixed side only
            $('.header, .side-left, .side-right').removeClass('fixed'); // remove first to normalize class
            $('.side-left, .side-right').addClass('fixed');
        }
        
        // help for responsive
        if(sessionStorage.mode == 4){
            // control for responsive
            if($(window).width() > 767){
                data_scroll = 60 - parseInt($(this).scrollTop());
                $('.side-left, .side-right').css({
                    'top' : data_scroll+'px'
                });
                $('body, html').animate({
                    scrollTop : 0
                })
            }
            else{
                $('.side-left, .side-right').css({
                    'top' : '0px'
                });
            }
        }
        else{
            if($(window).width() <= 767){
                $('.side-left, .side-right').css({
                    'top' : '0px'
                });
            }
            else{
                $('.side-left, .side-right').css({
                    'top' : '60px'
                });
            }
        }
    }
    
    // end control-mode
    
    // control for responsive
    $(window).resize(function(){
        if(sessionStorage.mode == 4){
            // control for responsive
            if($(window).width() > 767){
                data_scroll = 60 - parseInt($(this).scrollTop());
                $('.side-left, .side-right').css({
                    'top' : data_scroll+'px'
                });
                $('body, html').animate({
                    scrollTop : 0
                })
            }
            else{
                $('.side-left, .side-right').css({
                    'top' : '0px'
                });
            }
        }
        else{
            if($(window).width() <= 767){
                $('.side-left, .side-right').css({
                    'top' : '0px'
                });
            }
            else{
                $('.side-left, .side-right').css({
                    'top' : '60px'
                });
            }
        }
    });
    
    
    // scrolling event
    $(window).scroll(function() {
        
        // this for hide/show button to-top
        if($(this).scrollTop() > 480) {
            $('a[rel=to-top]').fadeIn('slow');	
        } else {
            $('a[rel=to-top]').fadeOut('slow');
        }
        
        // this for sincronize active sidebar item
        if($(this).scrollTop() > 35){
            if(sessionStorage.mode == 3 || sessionStorage.mode == 4 ){
                $('.sidebar > li:first-child.active').removeClass('first');
            }
        }
        else{
            $('.sidebar > li:first-child.active').addClass('first');
        }
        
        if(sessionStorage.mode){
            if(sessionStorage.mode == 4){
                if($(this).scrollTop() > 60){
                    $('.side-left, .side-right').css({
                        'top' : '0px'
                    });
                }
                else{
                    // control for responsive
                    if($(window).width() > 767){
                        data_scroll = 60 - parseInt($(this).scrollTop());
                        $('.side-left, .side-right').css({
                            'top' : data_scroll+'px'
                        });
                    }
                    else{
                        $('.side-left, .side-right').css({
                            'top' : '0px'
                        });
                    }
                }
            }
            else{
                $('.header').css({
                    'top' : '0px'
                });
            }
        }
        
    });
    
    $('a[rel=to-top]').click(function(e) {
        e.preventDefault();
        $('body,html').animate({
            scrollTop:0
        }, 'slow');
    });
    // end scroll to top
    
    
    // tooltip helper
    $('[rel=tooltip]').tooltip();	
    $('[rel=tooltip-bottom]').tooltip({
        placement : 'bottom'
    });	
    $('[rel=tooltip-right]').tooltip({
        placement : 'right'
    });
    $('[rel=tooltip-left]').tooltip({
        placement : 'left'
    });	
    // end tooltip helper
    
    
    // animate scroll, define class scroll will be activate this
    $(".scroll").click(function(e){
        e.preventDefault();
        $("html,body").animate({scrollTop: $(this.hash).offset().top-60}, 'slow');
    });
    // end animate scroll
    
    
    // control box
    // collapse a box
    $('.header-control [data-box=collapse]').click(function(){
        var collapse = $(this),
        box = collapse.parent().parent().parent();

        collapse.find('i').toggleClass('icofont-caret-up icofont-caret-down'); // change icon
        box.find('.box-body').slideToggle(); // toggle body box
    });
    
    // collapse on load
    $('.box-body[data-collapse=true]').slideUp() // slide up onload
    .parent() // on .box
    .find('.header-control [data-box=collapse] i').toggleClass('icofont-caret-up icofont-caret-down'); // find the controller and change default icon
    
    // close a box
    $('.header-control [data-box=close]').click(function(){
        var close = $(this),
        box = close.parent().parent().parent(),
        data_anim = close.attr('data-hide'),
        animate = (data_anim == undefined || data_anim == '') ? 'fadeOut' : data_anim;

        box.addClass('animated '+animate);
        setTimeout(function(){
            box.hide()
        },1000);
    });
    // end control box
    
    // toggle sideright
    toggle_sideright = false;
    $('.side-right[data-toggle=on]').animate({
        right: "-="+216+"px"
    });
    $('.side-right.side-right-large[data-toggle=on]').animate({
        right: "-="+329+"px" // total = 545px (216+329)
    });
    $('.sideright-toggle-nav').click(function(){
        //$('.content').toggleClass('.content-large').parent().toggleClass('span11 span9');
        width_sideright_cur = $('.side-right[data-toggle=on]').width();
        $('.sideright-toggle-nav > i').toggleClass('icofont-arrow-left icofont-arrow-right');
        
        if(toggle_sideright == false){
            $('.side-right[data-toggle=on], .sideright-toggle-nav').animate({
                right: "+="+width_sideright_cur+"px"
            });
            toggle_sideright = true;
        }
        else{
            $('.side-right[data-toggle=on], .sideright-toggle-nav').animate({
                right: "-="+width_sideright_cur+"px"
            });
        
            toggle_sideright = false;
        }
        
        return false;
    });
    
    $(window).scroll(function() {
        if($(this).scrollTop() > 60){
            $('.side-right[data-toggle=on]').css({
                'top' : '0px'
            });
        }
        else{
            $('.side-right[data-toggle=on]').css({
                'top' : '60px'
            });
        }
    });
    // end toggle sideright
    
    // helper ie9
    var browser = $.browser;
    if ( browser.msie && browser.version == "9.0" ) {
        $('.input-icon-append .grd-white').css({
            'filter' : "none"
        })
    }
})
