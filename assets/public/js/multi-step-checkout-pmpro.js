(function($) {
    'use strict';

    $(document).ready(function() {
        $(".pmpro_checkout").hide();
        // $(".pmpro_submit").hide();
        $("[id^='pmpro_checkout_box-']").show();

        var lastCustomFileds = $("[id^='pmpro_checkout_box-']").last();

        $('#ets-navigation-buttons-wrapper').children().clone(true).appendTo(lastCustomFileds);
		$('#ets-navigation-buttons-wrapper').children().clone(true).appendTo('#pmpro_user_fields');
		$('#ets-navigation-buttons-wrapper').children().clone(true).appendTo('#pmpro_billing_address_fields');
        
        function isLastStep() {
            return $('.step.active').next('.step').length === 0;
        }

        function toggleSubmitButton() {
            if (isLastStep()) {
                $('#pmpro_btn-submit').show();
            } else {
                $('#pmpro_btn-submit').hide();
            }
        }

        toggleSubmitButton();

        $('.step').click(function() {
            toggleSubmitButton();
        });

        $(".ets-nextBtn").click(function() {
            var allFieldsFilled = validateFields("[id^='pmpro_checkout_box-']:visible");
            // var allFieldsFilled = true;
            if (!allFieldsFilled) {
                $('.ets-prevBtn').hide();
                alert("Please fill in all fields before proceeding.");
                return;
            }

            var currentStep = $(".step.active");
            var nextStep = currentStep.next(".step");
            if (nextStep.length > 0) {
                currentStep.removeClass("active");
                nextStep.addClass("active");
                $(".pmpro_checkout").hide();
                $("#" + nextStep.data("step")).show();
                toggleSubmitButton();
            }

            if ($("#progress-steps .step:first-child").hasClass('active')) {
                $('.ets-prevBtn').hide();
            } else {
                $('.ets-prevBtn').show();
            }

            if ($("#progress-steps .step:last-child").hasClass('active')) {
                $('.ets-nextBtn').hide();
            } else {
                $('.ets-nextBtn').show();
            }
        });

        $(".ets-prevBtn").click(function() {
            var currentStep = $(".step.active");
            var prevStep = currentStep.prev(".step");
            if (prevStep.length > 0) {
                currentStep.removeClass("active");
                prevStep.addClass("active");
                $(".pmpro_checkout").hide();
                //Added check her if we are in Your infirmation Tab
                if ( prevStep.data("step") === 'pmpro_checkout_box-custom-fields' ){
                    $("[id^='pmpro_checkout_box-']").show();
                }else{
                    $("#" + prevStep.data("step")).show();
                }
                

                toggleSubmitButton();
            }
            if ($("#progress-steps .step:first-child").hasClass('active')) {
                $('.ets-prevBtn').hide();
            } else {
                $('.ets-prevBtn').show();
            }

            if ($("#progress-steps .step:last-child").hasClass('active')) {
                $('.ets-nextBtn').hide();
            } else {
                $('.ets-nextBtn').show();
            }
        });

        function validateFields(stepId) {
            var allFields = $(stepId).find(":input.pmpro_required");
            var allFieldsFilled = true;
            var radioGroups = {};
        
            allFields.each(function() {
                if ($(this).attr('type') === 'checkbox') {
        
                    if (!$(this).prop('checked')) {
                        allFieldsFilled = false;
                        $(this).addClass('error');
                    } else {
                        $(this).removeClass('error');
                    }
                } else if ($(this).attr('type') === 'radio') {
                    
                    var groupName = $(this).attr('name');
                    if (!radioGroups[groupName]) {
                        radioGroups[groupName] = false; 
                    }
                    if ($(this).prop('checked')) {
                        radioGroups[groupName] = true; 
                    }
                } else {
                    
                    if ($(this).val() === "") {
                        allFieldsFilled = false;
                        $(this).addClass('error');
                    } else {
                        $(this).removeClass('error');
                    }
                }
            });
        
        
            $.each(radioGroups, function(groupName, groupFilled) {
                if (!groupFilled) {
                    allFieldsFilled = false;
                    $('[name="' + groupName + '"]').addClass('error');
                } else {
                    $('[name="' + groupName + '"]').removeClass('error');
                }
            });
        
            return allFieldsFilled;
        }
        
        
        

    }); // DOM Ready

})(jQuery);
