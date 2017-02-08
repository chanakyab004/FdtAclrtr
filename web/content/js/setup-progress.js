var showSetupModal = function (onload) {
    if (onload == 'true') {
        var onload = 'true'
    } else {
        var onload = ''
    }

    $.ajax({
        url: 'getSetupProgress.php',
        dataType: 'json',
        success: function (response) {
            //console.log(response);
            if (response != null) {
                var setupProgressBar = 0;

                if (response.setupGeneral == 1) {
                    $('.setupProgressCheckmark#setupGeneral').attr('src','images/icons/checkmark_on.png');
                    $('.setupProgressCheckmark#setupGeneral').addClass('on');
                    setupProgressBar = Number(setupProgressBar + 12.5);
                } else {
                    $('.setupProgressCheckmark#setupGeneral').attr('src','images/icons/checkmark_off.png');
                    $('.setupProgressCheckmark#setupGeneral').removeClass('on');
                }

                if (response.setupUsers == 1) {
                    $('.setupProgressCheckmark#setupUsers').attr('src','images/icons/checkmark_on.png');
                    $('.setupProgressCheckmark#setupUsers').addClass('on');
                    setupProgressBar = Number(setupProgressBar + 12.5);
                } else {
                    $('.setupProgressCheckmark#setupUsers').attr('src','images/icons/checkmark_off.png');
                    $('.setupProgressCheckmark#setupUsers').removeClass('on');
                }

                if (response.setupServices == 1) {
                    $('.setupProgressCheckmark#setupServices').attr('src','images/icons/checkmark_on.png');
                    $('.setupProgressCheckmark#setupServices').addClass('on');
                    setupProgressBar = Number(setupProgressBar + 12.5);
                } else {
                    $('.setupProgressCheckmark#setupServices').attr('src','images/icons/checkmark_off.png');
                    $('.setupProgressCheckmark#setupServices').removeClass('on');
                }

                if (response.setupPricing == 1) {
                    $('.setupProgressCheckmark#setupPricing').attr('src','images/icons/checkmark_on.png');
                    $('.setupProgressCheckmark#setupPricing').addClass('on');
                    setupProgressBar = Number(setupProgressBar + 12.5);
                } else {
                    $('.setupProgressCheckmark#setupPricing').attr('src','images/icons/checkmark_off.png');
                    $('.setupProgressCheckmark#setupPricing').removeClass('on');
                }

                if (response.setupContract == 1) {
                    $('.setupProgressCheckmark#setupContract').attr('src','images/icons/checkmark_on.png');
                    $('.setupProgressCheckmark#setupContract').addClass('on');
                    setupProgressBar = Number(setupProgressBar + 12.5);
                } else {
                    $('.setupProgressCheckmark#setupContract').attr('src','images/icons/checkmark_off.png');
                    $('.setupProgressCheckmark#setupContract').removeClass('on');
                }

                if (response.setupEmails == 1) {
                    $('.setupProgressCheckmark#setupEmails').attr('src','images/icons/checkmark_on.png');
                    $('.setupProgressCheckmark#setupEmails').addClass('on');
                    setupProgressBar = Number(setupProgressBar + 12.5);
                } else {
                    $('.setupProgressCheckmark#setupEmails').attr('src','images/icons/checkmark_off.png');
                    $('.setupProgressCheckmark#setupEmails').removeClass('on');
                }

                if (response.setupWarranties == 1) {
                    $('.setupProgressCheckmark#setupWarranties').attr('src','images/icons/checkmark_on.png');
                    $('.setupProgressCheckmark#setupWarranties').addClass('on');
                    setupProgressBar = Number(setupProgressBar + 12.5);
                } else {
                    $('.setupProgressCheckmark#setupWarranties').attr('src','images/icons/checkmark_off.png');
                    $('.setupProgressCheckmark#setupWarranties').removeClass('on');
                }

                if (response.setupDisclaimers == 1) {
                    $('.setupProgressCheckmark#setupDisclaimers').attr('src','images/icons/checkmark_on.png');
                    $('.setupProgressCheckmark#setupDisclaimers').addClass('on');
                    setupProgressBar = Number(setupProgressBar + 12.5);
                } else {
                    $('.setupProgressCheckmark#setupDisclaimers').attr('src','images/icons/checkmark_off.png');
                    $('.setupProgressCheckmark#setupDisclaimers').removeClass('on');
                }

                if (setupProgressBar == '100') {
                    $('.progress-meter').css('width','100%');
                    $('.progress-meter-text').show();
                    $('.progress-meter-text').text('100%');
                    $('.progress').attr('aria-valuenow','100');
                    $('.progress').attr('aria-valuetext','100%');

                    $('.setupProgressMenu span').text('100%');

                    $('#setupComplete').parent().parent().parent().css('display','');
                }
                else if (setupProgressBar == '0') {
                    $('.progress-meter').css('width','0%');
                    $('.progress-meter-text').hide();
                    $('.progress').attr('aria-valuenow',0);
                    $('.progress').attr('aria-valuetext','0%');

                    $('.setupProgressMenu span').text('0%');

                    $('#setupComplete').parent().parent().parent().css('display','none');
                } else {
                    $('.progress-meter').css('width',setupProgressBar+'%');
                    $('.progress-meter-text').show();
                    $('.progress-meter-text').text(Math.round(setupProgressBar)+'%');
                    $('.progress').attr('aria-valuenow',setupProgressBar);
                    $('.progress').attr('aria-valuetext', Math.round(setupProgressBar) + '%');

                    $('.setupProgressMenu span').text(Math.round(setupProgressBar) + '%');

                    $('#setupComplete').parent().parent().parent().css('display','none');
                } 

                if (response.setupComplete != null) {
                    $('.setupProgressMenu').parent().remove();
                } else {
                    if (onload == 'true') {
                        if (response.showNotice >= 1) {
                            $('#setupModal').foundation('open'); 
                        } 
                    } else {
                        $('#setupModal').foundation('open'); 
                    }
                    
                }
                
            }
           
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
   
};

var updateChecks = function() {
    var setupCheck = $(this).attr('id');

    if ($('#'+setupCheck).hasClass('on')) {
        var setupCheckAnswer = 0;
    } else {
        var setupCheckAnswer = 1;
    }

    $.ajax({
        url: 'setupProgressUpdate.php',
        dataType: "json",
        contentType: 'application/json',
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        data: {
            setupCheck: setupCheck,
            setupCheckAnswer: setupCheckAnswer
        },
        success: function (response) {
            //console.log(response);
            if (response == 'true') {
                showSetupModal();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
};


var setupComplete = function() {
    
    $.ajax({
        url: 'setupProgressUpdate.php',
        dataType: "json",
        contentType: 'application/json',
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        data: {
            setupComplete: 'true'
        },
        success: function (response) {
            //console.log(response);
            if (response == 'true') {
                $('#setupModal').foundation('close'); 
                $('.setupProgressMenu').parent().remove(); 
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
};