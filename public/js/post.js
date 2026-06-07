// Image Post Slider
document.querySelectorAll('[data-slider]').forEach(slider => {

    const track = slider.querySelector('.sliderTrack');
    const slides = slider.querySelectorAll('.slide');
    const prev = slider.querySelector('.prev');
    const next = slider.querySelector('.next');

    if (track && prev && next && slides.length) {

        let index = 0;
        let moving = false;

        function update() {

            moving = true;

            track.style.transform =
                `translateX(-${index * 100}%)`;
        }

        track.addEventListener('transitionend', () => {
            moving = false;
        });

        next.addEventListener('click', () => {

            if (moving) return;

            if (index < slides.length - 1) {
                index++;
                update();
            }
        });

        prev.addEventListener('click', () => {

            if (moving) return;

            if (index > 0) {
                index--;
                update();
            }
        });
    }
});





document.addEventListener('click', function (e) {

    const card = e.target.closest('.js-post-card');

    if(card) {
        if (
            e.target.closest('a') ||
            e.target.closest('button') ||
            e.target.closest('form') ||
            e.target.closest('video')
        ) {
            return;
        }

        window.location.href = card.dataset.url;
    };
});






// Video observer
const videos = document.querySelectorAll('.postVideo');

const observer = new IntersectionObserver((entries) => {

    entries.forEach(entry => {

        const video = entry.target;

        if (entry.isIntersecting) {
            video.play();
        } else {
            video.pause();
        }
    });

}, {
    threshold: 0.6
});

videos.forEach(video => {
    observer.observe(video);
});