/**
 * @param {string[]} urls - Array of Image URLs
 * @returns {Promise<HTMLImageElement[]>} - Promise that resolves when all images are loaded, or rejects if any image fails to load
 */
function preloadImages(urls) {
    const promises = urls.map((url) => {
        return new Promise((resolve, reject) => {
        const image = new Image();

        image.src = url;

        image.onload = () => resolve(image);
        image.onerror = () => reject(`Image failed to load: ${url}`);
        });
    });

    return Promise.all(promises);
}
