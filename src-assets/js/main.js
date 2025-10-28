console.log('Theme loaded');
document.addEventListener('DOMContentLoaded', function () {
  const thumbnails = document.querySelectorAll(
    '.gallery-thumbnails .thumbnail'
  );
  const mainImage = document.querySelector('.main-image img');

  if (!thumbnails || !mainImage) return;

  thumbnails.forEach((thumb) => {
    thumb.addEventListener('click', function () {
      // Remove active class from all
      thumbnails.forEach((t) => t.classList.remove('active'));

      // Add active to clicked
      this.classList.add('active');

      // Update main image
      const newSrc = this.querySelector('img').src.replace('-150x150', '');
      mainImage.src = newSrc;
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('custom-cod-order-form');
  if (!form) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission

    const formData = new FormData(form);

    fetch('/wp-admin/admin-ajax.php?action=submit_custom_cod_order', {
      method: 'POST',
      body: formData,
      credentials: 'same-origin',
    })
      .then((response) => response.json())
      .then((data) => {
        const resultDiv = document.getElementById('order-result');
        if (data.success) {
          resultDiv.textContent = data.data.message;
          window.location.href = '/thank-you/';
        } else {
          resultDiv.textContent =
            'Error: ' + (data.data.message || 'Unknown error.');
        }
      });
  });
});
