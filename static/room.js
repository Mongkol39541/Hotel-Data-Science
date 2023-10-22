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
    timeline3.from("#animation3", { duration: 1, x: -200, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation3",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline3)
        .addTo(controller);

    let timeline4 = gsap.timeline();
    timeline4.from("#animation4", { duration: 1, x: 200, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation4",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline4)
        .addTo(controller);

    let timeline5 = gsap.timeline();
    timeline5.from("#animation5", { duration: 1, x: -200, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation5",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline5)
        .addTo(controller);

    let timeline6 = gsap.timeline();
    timeline6.from("#animation6", { duration: 1, x: 200, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation6",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline6)
        .addTo(controller);

    let timeline7 = gsap.timeline();
    timeline7.from("#animation7", { duration: 1, x: -200, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation7",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline7)
        .addTo(controller);
});