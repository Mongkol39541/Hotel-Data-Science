document.addEventListener('DOMContentLoaded', function () {
    let controller = new ScrollMagic.Controller();

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
    timeline3.from("#animation3", { duration: 1, y: 150, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation3",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline3)
        .addTo(controller);
});