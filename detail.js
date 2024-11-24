
const comments = [
    {
      text: "Semoga para warga di sana diberikan ketabahan dan juga kesabaran menghadapinya",
      author: "Andrew Garfield",
      avatar: "asset/andrew.webp"
    },
    {
      text: "Saya harap semua bisa segera pulih dan kembali normal.",
      author: "Emma Watson",
      avatar: "asset/emma.webp"
    },
    {
      text: "Jangan pernah menyerah, pasti ada harapan di balik kesulitan ini.",
      author: "Tom Holland",
      avatar: "asset/tom.webp"
    }
  ];
  
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
  
  // Add click event to indicators
  indicators.forEach((tombol, index) => {
    tombol.addEventListener('click', () => {
      currentIndex = index;
      updateSlider(index);
    });
  });
  
  // Auto-slider with reverse loop
  setInterval(() => {
    currentIndex++;
    if (currentIndex >= comments.length) {
      currentIndex = 0; // Reset to the first slide
    }
    updateSlider(currentIndex);
  }, 5000); // Every 5 seconds
  
  function initializeSlider() {
    commentSlider.innerHTML = comments
      .map(
        (comment) => `
        <div class="contain">
            <p class="komen">${comment.text}</p>
            <div class="pp">
                <img src="${comment.avatar}">
                <span>${comment.author}</span>
            </div>
        </div>
    `
      )
      .join('');
  }
  initializeSlider();
  