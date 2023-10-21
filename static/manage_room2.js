$(document).ready(function () {
    var table = $('#tableSearch').DataTable({
        lengthChange: true,
        buttons: ['copy', 'excel', 'pdf', 'csv', 'colvis'],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    table.buttons().container()
        .appendTo('#tableSearch_wrapper .col-md-6:eq(0)');
});

$(document).on("click", "#Update", function () {
    var room_id = $(this).data("roomid");
    var room_type = $("#roomtype_" + room_id).text();
    var room_size = parseInt($("#roomsize_" + room_id).text());
    var bed_type = $("#bedtype_" + room_id).text();
    var capacity = parseInt($("#capacity_" + room_id).text());
    var price = parseInt($("#price_" + room_id).text());
    var facility = $("#facility_" + room_id).val();
    var description = $("#description_" + room_id).val();
    var room_img = $("#roomimg_" + room_id).val();
    $.ajax({
        url: "manage_room.php",
        method: "POST",
        success: function () {
            $("#formID").val(room_id);
            $("#formRID").text("ID #" + room_id);
            $("#" + room_type).prop("checked", true);
            $("#formSize").val(room_size);
            $("#" + bed_type).prop("checked", true);
            $("#formCapacity").val(capacity);
            $("#formPrice").val(price);
            $("#formfacility").val(facility);
            $("#formdescription").val(description);
            $("#formImage").val(room_img);
        }
    });
});

$(document).on("click", "#Delete", function () {
    var room_id = $(this).data("roomid");
    $.ajax({
        url: "manage_room.php",
        method: "POST",
        success: function () {
            $("#outDelete").val(room_id);
            $("#textDelete").text("Delete ID #" + room_id)
        }
    });
});

(() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();

document.addEventListener('DOMContentLoaded', function () {
    let controller = new ScrollMagic.Controller();
    let timeline1 = gsap.timeline();
    timeline1.from("#animation1", { duration: 1, x: -1500, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation1",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline1)
        .addTo(controller);
    let timeline2 = gsap.timeline();
    timeline2.from("#animation2", { duration: 1, x: 1500, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation2",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline2)
        .addTo(controller);
    let timeline3 = gsap.timeline();
    timeline3.from("#animation3", { duration: 1, y: 100, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation3",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline3)
        .addTo(controller);
    let image = document.querySelector('.bg-image');
    let text = document.querySelector('.text-white');
    gsap.set([image, text], { autoAlpha: 0, y: 100 });
    let timeline = gsap.timeline({ defaults: { duration: 1 } });
    timeline
        .to(image, { autoAlpha: 1, y: 0 })
        .to(text, { autoAlpha: 1, y: 0 }, '-=0.5');
});

mdb.Alert.getInstance(document.getElementById("alertExample")).update({
    position: "top-right",
    delay: 2000,
    autohide: false,
    width: "600px",
    offset: 20,
    stacking: false,
    appendToBody: false,
});