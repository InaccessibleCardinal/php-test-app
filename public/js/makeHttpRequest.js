function makeHttpRequest({url, method, data}) {
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.open(method, url);
    xhr.onload = function() {
      if (this.status < 400) {
        return resolve(this.responseText);
      }
      reject(new Error('error encountered'));
    }
    xhr.send(method === 'POST' ? JSON.stringify(data) : null);
  });
}