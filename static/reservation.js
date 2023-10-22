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
});