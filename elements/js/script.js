// Lazy load for iframes
// The video will load when you hover over it
document.addEventListener("DOMContentLoaded", function() {
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                // Get the iframe and set the src from data-src
                var PWEIframe = entry.target;
                if (PWEIframe.getAttribute('data-src')) {
                    PWEIframe.src = PWEIframe.getAttribute('data-src');
                    // PWEIframe.removeAttribute('data-src'); // Remove data-src
                }
                // Unobserving this item
                observer.unobserve(PWEIframe);
            }
        });
    }, 
    
    {
        rootMargin: '100px 0px', // Increase the watchable area
        threshold: 0.1
    });

    // Start observing iframes
    document.querySelectorAll('.custom-video-item iframe[data-src]').forEach(function(PWEIframe) {
        observer.observe(PWEIframe);
    });
});
  
// Added shadow for iframes
const PWEIframes = document.querySelectorAll('.custom-video-item iframe');
if (PWEIframes) {
    PWEIframes.forEach((PWEIframe) => PWEIframe.classList.add('iframe-shadow'));
}
  