const filter_label = document.querySelector('.filterLabel');
const filter_labeltwo = document.querySelector('.two');
const filter_labelthree = document.querySelector('.three');

function toggleActiveClass(element, otherElements) {
  element.classList.toggle('is-active');

  otherElements.forEach((otherElement) => {
    if (otherElement.classList.contains('is-active')) {
      otherElement.classList.remove('is-active');
    }
  });
}

filter_label.addEventListener('click', function() {
  toggleActiveClass(filter_label, [filter_labeltwo, filter_labelthree]);
});

filter_labeltwo.addEventListener('click', function() {
  toggleActiveClass(filter_labeltwo, [filter_label, filter_labelthree]);
});

filter_labelthree.addEventListener('click', function() {
  toggleActiveClass(filter_labelthree, [filter_label, filter_labeltwo]);
});
