/**
 * Created by Christiaan Goslinga on 29-11-2017.
 */

$(document).ready(function() {
    $.ajax({ url: window.location.protocol + "//" + window.location.host + "/windesheim/KBS-groep-2/src/users/User.php",
        data: {action: 'get'},
        type: 'post',
        success: function(result) {
            console.log(result);
            $(".users").append(result);
        }
    });
});

$(document).ready(function() {
    setTimeout(function() {
        $(".approve").click(function() {
            console.log("approve");
            $.ajax({ url: window.location.protocol + "//" + window.location.host + "/windesheim/KBS-groep-2/src/users/User.php",
                data: {action: 'approve', username: $(this).val()},
                type: 'post',
                success: function(result) {
                    console.log(result);
                    $(".message-body").html(result);
                }
            });
        });

        $(".delete").click(function() {
            console.log("delete");
            $.ajax({ url: window.location.protocol + "//" + window.location.host + "/windesheim/KBS-groep-2/src/users/User.php",
                data: {action: 'delete', username: $(this).val()},
                type: 'post',
                success: function(result) {
                    console.log(result);
                    $(".message-body").html(result);
                }
            });
        });

        $(".function").on("change", function() {
            console.log("change");
            $.ajax({ url: window.location.protocol + "//" + window.location.host + "/windesheim/KBS-groep-2/src/users/User.php",
                data: {action: 'change', username: $(this).attr('data-username'), functie: $(this).val()},
                type: 'post',
                success: function(result) {
                    console.log(result);
                    $(".message-body").html(result);
                }
            });
        });
    }, 100);
});