(function($) {
    'use strict';

    $(document).ready(function() {
        $(".pmpro_checkout").hide();
        // $(".pmpro_submit").hide();
        $("[id^='pmpro_checkout_box-']").show();
        
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
                $("#" + prevStep.data("step")).show();
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
            var allFields = $(stepId).find(":input").not(":checkbox[name='kt_supports']").not(":checkbox[name='kt_article_links']").not(":input[name='ets_middle_name']").not(":input[name='ets_website_url']").not(":input[name='ets_telehealth_platforms']");
            var allFieldsFilled = true;
            allFields.each(function() {
                if ($(this).val() === "") {
                    allFieldsFilled = false;
                    return false;
                }
            });
            return allFieldsFilled;
        }

    }); // DOM Ready

})(jQuery);
