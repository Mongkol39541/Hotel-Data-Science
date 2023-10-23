document.addEventListener('DOMContentLoaded', function () {
    let controller = new ScrollMagic.Controller();
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
