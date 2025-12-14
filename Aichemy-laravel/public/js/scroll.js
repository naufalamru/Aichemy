document.addEventListener('DOMContentLoaded', function () {
  const elements = document.querySelectorAll('[data-anim]');
  // add initial animate class
  elements.forEach(el => el.classList.add('animate'));

  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // small delay berdasarkan posisi untuk stagger
        const delay = (entry.target.datasetDelay) ? parseInt(entry.target.datasetDelay) : 0;
        setTimeout(() => {
          entry.target.classList.add('visible');
        }, delay);
        // unobserve if you want animation once
        io.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.12
  });

  elements.forEach(el => io.observe(el));
});
