const shortenResult = document.getElementById('shorten-result');
const shortenForm = document.getElementById('shorten-form');
shortenForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const url = e.target.url.value;
    const action = e.target.action;
    fetch(action + '?url=' + encodeURIComponent(url))
    .then(response => response.json())
    .then(data => {
        shortenResult.innerHTML = `
            <p>Short URL: <a href="${window.location.origin}/${data.code}" target="_blank">${window.location.origin}/${data.code}</a></p>
        `;
    });
});
