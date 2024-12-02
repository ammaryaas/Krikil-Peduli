// Ambil data komentar dari server
async function fetchComments() {
  try {
    const response = await fetch('comments.php'); // Ganti dengan URL yang sesuai
    const data = await response.json();
    
    // Update slider dengan data komentar
    updateCommentsSlider(data);
  } catch (error) {
    console.error("Error fetching comments:", error);
  }
}

// Update slider dengan data komentar
function updateCommentsSlider(comments) {
  let currentIndex = 0;
  const commentSlider = document.querySelector('.slider');
  const indicators = document.querySelectorAll('.tombol');

  function updateSlider(index) {
    commentSlider.style.transform = `translateX(-${index * 100}%)`;

    indicators.forEach((tombol, i) => {
      if (i === index) {
        tombol.classList.add('active');
      } else {
        tombol.classList.remove('active');
      }
    });
  }

  // Menampilkan komentar dalam slider
  commentSlider.innerHTML = comments
    .map(
      (comment) => `
      <div class="contain">
        <p class="komen">${comment.text}</p>
        <div class="pp">
          <img src="${comment.avatar}" alt="${comment.author}">
          <span>${comment.author}</span>
        </div>
      </div>
    `
    )
    .join('');

  // Set indikator dan auto-slider
  indicators.forEach((tombol, index) => {
    tombol.addEventListener('click', () => {
      currentIndex = index;
      updateSlider(index);
    });
  });

  // Auto-slider dengan reverse loop
  setInterval(() => {
    currentIndex++;
    if (currentIndex >= comments.length) {
      currentIndex = 0; // Reset to the first slide
    }
    updateSlider(currentIndex);
  }, 5000); // Every 5 seconds
}

// Panggil fungsi untuk mengambil komentar
fetchComments();
