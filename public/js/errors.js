const errorContainer = document.getElementById('errors');
function makeError(message) {
  const p = document.createElement('p');
  const b = document.createElement('button');
  b.innerHTML = 'clear';
  b.addEventListener('click', () => {
    errorContainer.innerHTML = '';
  });
  p.innerHTML = message;
  p.style = 'color: red;';
  errorContainer.appendChild(p);
  errorContainer.appendChild(b);
}