document.addEventListener('DOMContentLoaded', function () {
    let controller = new ScrollMagic.Controller();
    let timeline1 = gsap.timeline();
    timeline1.from("#animation1", { duration: 1, x: -200, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation1",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline1)
        .addTo(controller);
    let timeline2 = gsap.timeline();
    timeline2.from("#animation2", { duration: 1, x: 200, opacity: 0 });
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
});

$(document).ready(function () {
    var table = $('#tableSearch').DataTable({
        lengthChange: true,
        buttons: ['copy', 'excel', 'pdf', 'csv', 'colvis'],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    table.buttons().container()
        .appendTo('#tableSearch_wrapper .col-md-6:eq(0)');
});
