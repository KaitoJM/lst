jQuery(function () {
    $(".view-more").on("click", function () {
        let data = $(this).closest(".item").data("info");
        let itemElem = $(this).closest(".item");

        $("body").append(
            $("<img src='images/" + data.image + "' id='test' />").css({
                top: itemElem.position().top + 5,
                left: itemElem.position().left + 5,
                width: itemElem.width(),
                height: itemElem.height(),
            })
        );

        $("#popupwrapper").show();

        setTimeout(function () {
            $("#test").addClass("expanded");
            $("#popupwrapper").addClass("shown");
            $("#project-title").html(data.title);
            $("#project-description").html(data.description);
            setTimeout(function () {
                $("#project-info-content").css({
                    marginTop: $("#test").height() + 130,
                    opacity: 1,
                });
            }, 500);
        }, 1);
    });

    $("#popupwrapper").on("click", function () {
        $("#popupwrapper").removeClass("shown");
        $("#test").removeClass("expanded");

        setTimeout(function () {
            $("#test").remove();
            $("#popupwrapper").hide();
            $("#project-title").html("");
            $("#project-description").html("");
            $("#project-info-content").css({
                marginTop: 0,
                opacity: 0,
            });
        }, 500);
    });

    $("#project-info-content").on("click", function (e) {
        e.stopPropagation();
    });
});
