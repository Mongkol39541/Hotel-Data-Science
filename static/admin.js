document.addEventListener('DOMContentLoaded', function () {
    let controller = new ScrollMagic.Controller();

    let timeline1 = gsap.timeline();
    timeline1.from("#animation1", { duration: 1, y: 150, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation1",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline1)
        .addTo(controller);

    let timeline2 = gsap.timeline();
    timeline2.from("#animation2", { duration: 1, y: 150, opacity: 0 });
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

    let timeline4 = gsap.timeline();
    timeline4.from("#animation4", { duration: 1, y: 150, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation4",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline4)
        .addTo(controller);

    let timeline5 = gsap.timeline();
    timeline5.from("#animation5", { duration: 1, y: 150, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation5",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline5)
        .addTo(controller);

    let timeline6 = gsap.timeline();
    timeline6.from("#animation6", { duration: 1, y: 100, opacity: 0 });
    new ScrollMagic.Scene({
        triggerElement: "#animation6",
        triggerHook: 1,
        reverse: true
    })
        .setTween(timeline6)
        .addTo(controller);

    let image = document.querySelector('.bg-image');
    let text = document.querySelector('.text-white');
    gsap.set([image, text], { autoAlpha: 0, y: 100 });
    let timeline = gsap.timeline({ defaults: { duration: 1 } });
    timeline
        .to(image, { autoAlpha: 1, y: 0 })
        .to(text, { autoAlpha: 1, y: 0 }, '-=0.5');
});