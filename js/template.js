// check and define $ as jQuery
if (typeof jQuery != "undefined") jQuery(function ($) {

    // Close Joomla system messages (for example)
    $('#system-message .close').click(function () {

        $(this).closest('.alert')
            .animate({ height: 0, opacity: 0 }, 'slow', function () {
                $(this).remove();
            });
        return false;
    });

    // Your JavaScript and jQuery code here
    // alert('JS Test!');

});
