// check and define $ as jQuery
if (typeof jQuery != "undefined") jQuery(function ($) {
    
    // dump(myVar); is wrapper for console.log() with check existing console object and show 
    window.dump=function(vars,name,showTrace){if(typeof console=="undefined")return false;if(typeof vars=="string"||typeof vars=="array")var type=" ("+typeof vars+", "+vars.length+")";else var type=" ("+typeof vars+")";if(typeof vars=="string")vars='"'+vars+'"';if(typeof name=="undefined")name="..."+type+" = ";else name+=type+" = ";if(typeof showTrace=="undefined")showTrace=false;console.log(name,vars);if(showTrace)console.trace();return true};

    // remove no-js class if JavaScript enabled
    $('html.no-js').removeClass('no-js').addClass('js-ready');

    // close Joomla system messages (just example)
    $('#system-message .close').click(function () {
        $(this).closest('.alert').animate({height: 0, opacity: 0, MarginBottom: 0}, 'slow', function () {
            $(this).remove();
        });
        return false;
    });

    // your JavaScript and jQuery code here
    // alert('JS Test!');

});
