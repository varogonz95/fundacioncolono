(function ( $ ) {
    $.fn.animatedModal = function(options) {

        var e = this,

        settings = $.extend(true,{
            //overlay:{show:true,opacity:'.8',closeOnClick:false},
            animatedIn:'slideInUp',
            animatedOut:'slideOutDown',
            style:{
                'position':'fixed',
                'width':'100%',
                'bottom':'0',
                'left':e.parent().css('left'),
                'background-color':'white',
                'overflow-y':'auto',
                'z-index':'100',
                '-webkit-animation-duration':'.4s',
                '-moz-animation-duration':'.4s',
                '-ms-animation-duration':'.4s',
                'animation-duration':'.4s'
            },
            onBeforeShow: function(){},
            onAfterShow: function(){},
            onBeforeClose: function(){},
            onAfterClose: function(){},
        },options),

        init = function(){
            e.show = show;
            e.close = close;
            e.applyStyle = applyStyle;
            e.set = set;

            set();
            applyStyle();

            e.find('.close-animatedModal').click(close);
        },

        show = function(){

            settings.onBeforeShow();

            if(e.css('display') === 'none'){e.css('display','block');}

            e.removeClass(settings.animatedOut)
            .addClass(settings.animatedIn);

            settings.onAfterShow();

        },

        close = function(){

            settings.onBeforeClose();

            e.removeClass(settings.animatedIn)
            .addClass(settings.animatedOut);
        }

        set = function(conf, merge=true){
            settings = (merge)? $.extend(true, settings, conf) : settings = conf;
        }

        applyStyle = function(style){
            e.css(style || settings.style);
        }

        init();
        console.log('Modal initiated');

        return this;
    };
}( jQuery ));

// angular.element.prototype.animatedModal =  function(a){
//
//
//
//     //     - hide(before,after)
//     //     - set(conf,merge=true)
//
//     if (this[0].hasAttribute('init')) {
//         console.log('has attribute init');
//     }
//     else {
//         console.log('has not');
//         this.attr('init','');
//
//         var e = this,
//         settings = {
//             overlay:{show:true,opacity:'.8',closeOnClick:false},
//             animatedIn:'bounceInUp',
//             animatedOut:'bounceOutDown',
//             style:{
//                 'position':'fixed',
//                 'width':$(e.parent()).css('width'),
//                 'bottom':'0',
//                 'left':$(e.parent()).css('left'),
//                 'background-color':'white',
//                 'overflow-y':'auto',
//                 'z-index':'100',
//                 '-webkit-animation-duration':'.6s',
//                 '-moz-animation-duration':'.6s',
//                 '-ms-animation-duration':'.6s',
//                 'animation-duration':'.6s'
//             },
//             // Callbacks
//             beforeOpen: function() {},
//             afterOpen: function() {},
//             beforeClose: function() {},
//             afterClose: function() {}
//         },
//         show = function(){
//             $(e[0]).css('display','block')
//             .addClass(settings.animatedIn);
//         },
//         close = function(){
//             $(e[0]).removeClass(settings.animatedIn)
//             .addClass(settings.animatedOut);
//         };
//
//         if(typeof a == 'object'){settings=angular.merge(settings, a);}
//
//         e.css(settings.style);
//
//         $(e[0]).find('.close-animatedModal').click(function(){close();});
//
//     }
//
//     if(typeof a == 'string'){
//         switch (a) {
//             case 'show':
//             show();
//             break;
//         }
//     }
//
// }
