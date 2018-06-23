/**
 *
 * за валидация на sign up формата
 */
var unique = true;
$(document).ready(function () {

    $('#googleLogInButton').click(function () {
        location = signUpFormVariables['googleLogInRoute'];
    });

    if (!signUpFormVariables['logIn']) {
        if (signUpFormVariables.authUser) {
            $('#signUpButton').click(function (event) {
                event.preventDefault();
                location = signUpFormVariables['CalendarRoute'];
            });
        }
        else {
            $.fn.form.settings.rules.checkEmail = function (value) {
                //var unique = true;

                axios.post(signUpFormVariables['CheckEmailUniqueRoute'], {
                    email: value
                })
                    .then(function (response) {
                        unique = true;
                    })
                    .catch(function (error) {
                        unique = false;
                    });
                return unique;
            };
            $('.ui.form')
                .form({
                    fields: {
                        email: {
                            identifier: 'email',
                            rules: [
                                {
                                    type: 'email',
                                    prompt: signUpFormVariables['validation']['email']['emailPrompt']
                                },
                                {
                                    type: 'checkEmail',
                                    prompt: signUpFormVariables['validation']['email']['uniquePrompt']
                                }
                            ]
                        },
                        password: {
                            identifier: 'password',
                            rules: [

                                {
                                    type: 'empty',
                                    prompt: signUpFormVariables['validation']['password']['emptyPrompt']
                                },
                                {
                                    type: 'minLength[6]',
                                    prompt: signUpFormVariables['validation']['password']['minLenghtPrompt']
                                }
                            ]
                        },
                        password_confirmation: {
                            identifier: 'password_confirmation',
                            optional: function () {
                                if (signUpFormVariables['logIn']) {
                                    return true;
                                }
                                return false
                            },
                            rules: [
                                {
                                    type: 'match[password]',
                                    prompt: signUpFormVariables['validation']['password_confirmation']['matchPrompt']
                                },
                            ]
                        },

                    },
                    onFailure: function (formErrors, fields) {
                        navigator.vibrate([100, 100, 200]);
                        return false;
                    }
                });

            $('[name=password]').on('input', function () {

                if ($('[name=password]').val()) {
                    $('[name=password_confirmation]').parent().fadeIn(200);
                }
                else {
                    $('[name=password_confirmation]').parent().fadeOut(200, function () {
                        $('[name=password_confirmation]').val('')
                    });
                }

            })

        }
    }


});