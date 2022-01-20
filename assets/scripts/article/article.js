const post = document.querySelector('.post__copy');
const heart = document.querySelector('.icon');

post.addEventListener("click", () => {
  heart.classList.add("beat");
  // countEl.innerHTML = count;
  setTimeout(() => {
    heart.classList.remove("beat");
  }, 1200);
});
